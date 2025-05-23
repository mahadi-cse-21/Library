<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use App\Models\Borrow;
use App\Models\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class HistoryController extends Controller
{
    //
    public function index()
    {



        $currentBorrows = Borrow::with('book', 'student.user')
            ->where('student_id', Auth::user()->id)
            ->where('status', 'borrowed')
            ->paginate(5);


        $requests = Requests::with('book', 'student.user')
            ->where('status', 'pending')
            ->where('student_id', Auth::user()->id)
            ->get();
        $borrows = Borrow::with('book')
            ->where('student_id', Auth::user()->id)
            ->paginate(5);

        $return_this_month = Borrow::where('status', 'returned')
            ->where('student_id', Auth::user()->id) // or Auth::user()->id
            ->count();


        //dd($borrows);

        return view('student.history', [
            'currentBorrows' => $currentBorrows,
            'requests' => $requests,
            'borrows' => $borrows,
            'return_this_month' => $return_this_month,
        ]);
    }
     public function cancel($id)
    {
        DB::transaction(function () use ($id) {
            $request = Requests::findOrFail($id);
            $request->status = "canceled";
            $request->save();

            Mail::to($request->student->user->email)->send(new TestMail($request));
        });

        // Optionally return a response or redirect
        return redirect()->back()->with('status', 'Request canceled successfully.');
    }
  
}
