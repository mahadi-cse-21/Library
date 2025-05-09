<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rules;

class AdminStudentController extends Controller
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
        
        $students = $query->paginate(5);
        
        return view('admin.students', compact('students'));
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

        // dd($request->all());
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'student_uid'=>['required','string'],
            'img' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
      
       
        
        $imageName = time().'.'.$request->img->extension();  
        $path = $request->file('img')->storeAs('images', $imageName, 'public');
       
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => 'student',
            'is_active' => true,
            'img' => $path,
            'password' => Hash::make($request->password),
        ]);
        



        event(new Registered($user));
        // Create student

      
         $student = Student::create([
            'id' => $user->id,
            'student_id' => $request->student_uid,
            'department' => $request->department,
            'year' =>$request->year,
            'semester'=>$request->semester,
            'status' => $request->status,
            'book_borrowed' => 0,
            'current_borrows' => 0
        ]);

        
        
        return redirect()->back()->with('success', 'Student created successfully.');
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

    public function viewstudentform()
    {
        return view('admin.addstudent');
    }

    /**
     * Import students from Excel/CSV
     */
    
    /**
     * Export students to Excel
     */
  
}
