<?php

namespace App\Http\Controllers;

use App\Exports\StudentsExport;
use App\Models\Borrow;
use App\Models\Requests;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    //
    public function index()
    {


        $currently = Borrow::where('id', Auth::user()->id)
            ->where('status', 'borrowed')->count();

        $reserveBook = Requests::where('student_id', Auth::user()->id)
            ->where('type', 'reserve')->count();

        $nextdueDate = Borrow::where('student_id', Auth::user()->id)
            ->where('status', 'borrowed')
            ->orderBy('due_date', 'asc')
            ->first();
        $nextdue = $nextdueDate ? $nextdueDate->due_date : null;


        $currentBorrows = Borrow::with('book_copy.book')
            ->where('student_id', Auth::user()->id)
            ->paginate(5);






        return view('student.dashboard', [
            'reservedBook' => $reserveBook,
            'currently' => $currently,
            'nextdue' => $nextdue,
            'currentlyBorrows' => $currentBorrows,

        ]);
    }
   
}
