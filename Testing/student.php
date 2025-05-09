// CONTROLLER: StudentController.php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentsExport;
use App\Imports\StudentsImport;

class StudentController extends Controller
{
    /**
     * Display a listing of students.
     */
    public function index(Request $request)
    {
        $query = Student::with('user');
        
        // Apply filters if they exist
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }
        
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('student_id', 'like', "%{$search}%");
        }
        
        $students = $query->paginate(15);
        
        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'student_id' => 'required|string|unique:students',
            'department' => 'required|string',
            'year' => 'required|string',
            'profile_image' => 'nullable|image|max:2048',
        ]);
        
        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'student'
        ]);
        
        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile-images', 'public');
            $user->img = $path;
            $user->save();
        }
        
        // Create student
        Student::create([
            'user_id' => $user->id,
            'student_id' => $validated['student_id'],
            'department' => $validated['department'],
            'year' => $validated['year'],
            'status' => 'active',
            'book_borrowed' => 0,
            'current_borrows' => 0
        ]);
        
        return redirect()->route('students.index')
            ->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified student.
     */
    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $student->user_id,
            'department' => 'required|string',
            'year' => 'required|string',
            'profile_image' => 'nullable|image|max:2048',
        ]);
        
        // Update User
        $user = $student->user;
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        
        // Handle password update if provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8',
            ]);
            $user->password = Hash::make($request->password);
        }
        
        // Handle profile image update
        if ($request->hasFile('profile_image')) {
            // Remove old image if exists
            if ($user->img) {
                Storage::disk('public')->delete($user->img);
            }
            $path = $request->file('profile_image')->store('profile-images', 'public');
            $user->img = $path;
        }
        
        $user->save();
        
        // Update student
        $student->department = $validated['department'];
        $student->year = $validated['year'];
        $student->save();
        
        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    /**
     * Toggle student status (suspend/reactivate).
     */
    public function toggleStatus(Student $student)
    {
        if ($student->status == 'suspended') {
            $student->status = 'active';
            $message = 'Student reactivated successfully.';
        } else {
            $student->status = 'suspended';
            $message = 'Student suspended successfully.';
        }
        
        $student->save();
        
        return redirect()->route('students.index')
            ->with('success', $message);
    }

    /**
     * Show import form
     */
    public function importForm()
    {
        return view('students.import');
    }

    /**
     * Import students from Excel/CSV
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls|max:2048',
        ]);
        
        try {
            Excel::import(new StudentsImport, $request->file('file'));
            
            return redirect()->route('students.index')
                ->with('success', 'Students imported successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error importing students: ' . $e->getMessage());
        }
    }

    /**
     * Export students to Excel
     */
    public function export(Request $request)
    {
        // Apply filters for the export
        $query = Student::with('user');
        
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }
        
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('student_id', 'like', "%{$search}%");
        }
        
        $students = $query->get();
        
        return Excel::download(new StudentsExport($students), 'students.xlsx');
    }
}

// IMPORT CLASS: StudentsImport.php

namespace App\Imports;

use App\Models\Student;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

class StudentsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Create user first
        $user = User::create([
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => Hash::make($row['password'] ?? 'password123'), // Default password if not provided
            'role' => 'student',
        ]);
        
        // Then create student record
        return new Student([
            'user_id' => $user->id,
            'student_id' => $row['student_id'],
            'department' => $row['department'],
            'year' => $row['year'] ?? '1',
            'status' => $row['status'] ?? 'active',
            'book_borrowed' => $row['book_borrowed'] ?? 0,
            'current_borrows' => $row['current_borrows'] ?? 0,
        ]);
    }
}

// EXPORT CLASS: StudentsExport.php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $students;

    public function __construct($students)
    {
        $this->students = $students;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->students;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Student ID',
            'Name',
            'Email',
            'Department',
            'Year Level',
            'Books Borrowed',
            'Current Borrows',
            'Status',
            'Registration Date'
        ];
    }

    /**
     * @param mixed $student
     * @return array
     */
    public function map($student): array
    {
        return [
            $student->student_id,
            $student->user->name,
            $student->user->email,
            $student->department,
            $student->year,
            $student->book_borrowed,
            $student->current_borrows,
            $student->status,
            $student->created_at->format('M d, Y')
        ];
    }
}