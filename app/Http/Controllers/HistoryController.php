<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    //
    public function index()
    {

       

        $currentBorrows = Borrow::with('book_copy.book', 'student.user')
            ->where('student_id', Auth::user()->id)
            ->paginate(5);
          

        $requests = Requests::with('bookCopy.book','student.user')
            ->where('status', 'pending')
            ->where('student_id', Auth::user()->id)
            ->get();
        $borrows = Borrow::with('book_copy.book')
        ->where('student_id', Auth::user()->id)
        ->paginate(5);


             //dd($borrows);

        return view('student.history', [
            'currentBorrows' => $currentBorrows,
            'requests' => $requests,
            'borrows' => $borrows,
        ]);
    }
}
