<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\User;
use App\Notifications\OverdueBooksNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //

 public function index()
 {
    return view('student.notification');
 }
    public function sendOverdue(Request $request)
    {
        $overdue_books = Borrow::where('due_date', '<', Carbon::today())
            ->whereNull('return_date')
            ->with('student.user', 'book_copy.book')
            ->get();

        foreach ($overdue_books as $borrow) {
            $user = $borrow->student->user;
            $user->notify(new OverdueBooksNotification($borrow));
        }


        return back()->with('success', 'Notifications sent.');
    }
}
