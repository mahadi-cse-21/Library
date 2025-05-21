<?php

namespace App\Http\Controllers;

use App\Exports\StudentsExport;
use App\Models\Book;
use App\Models\Book_Copy;
use App\Models\Borrow;
use App\Models\Requests;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    //
    public function index()
    {

        $student = Student::findOrFail(Auth::user()->id);
        $currently = Borrow::where('student_id', Auth::user()->id)
            ->where('status', 'borrowed')->count();

        $reserveBook = Requests::where('student_id', Auth::user()->id)
            ->where('type', 'reserve')->count();

        $nextdueDate = Borrow::where('student_id', Auth::user()->id)
            ->where('status', 'borrowed')
            ->orderBy('due_date', 'asc')
            ->first();
        $nextdue = $nextdueDate ? $nextdueDate->due_date : null;


        $currentBorrows = Borrow::with('book', 'student')
            ->where('student_id', Auth::user()->id)
            ->paginate(5);

        $recommendations = Borrow::with(['student', 'book']) // Eager load related book
            ->whereIn('status', ['borrowed', 'returned'])
            ->select('book_id', DB::raw('COUNT(*) as total'))
            ->groupBy('book_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();


        return view('student.dashboard', [
            'reservedBook' => $reserveBook,
            'currently' => $currently,
            'nextdue' => $nextdue,
            'currentlyBorrows' => $currentBorrows,
            'recommendations' => $recommendations,
            'student' => $student,
        ]);
    }
}
