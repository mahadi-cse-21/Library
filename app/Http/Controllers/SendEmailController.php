<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\User;
use App\Notifications\OverdueBooksNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SendEmailController extends Controller
{
    //

    public function __invoke()
    {
        $overdue_books = Borrow::where('due_date', '<', Carbon::today())
            ->where('status', 'borrowed')
            ->whereNull('return_date')
            ->with(['student.user','book_copy.book'])
            ->get();
    
        $notifiedUsers = [];
    
        foreach ($overdue_books as $overdue_book) {
            if ($overdue_book->student && $overdue_book->student->user) {
                $user = $overdue_book->student->user;
                $user->notify(new OverdueBooksNotification($overdue_book));
                $notifiedUsers[] = $user->email;
            }
        }
    
        if (count($notifiedUsers)) {
            return redirect()->back()->with('success', 'Notifications sent to: ' . implode(', ', $notifiedUsers));
        }
        
        return redirect()->back()->with('info', 'No users found.');
    }
    public function notify($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }
    
        $notifiedUsers = [];

        $overdue= Borrow::where('due_date','<',Carbon::today())
        ->where('status','borrowed')
        ->whereNull('return_date')
        ->where('student_id',$id);
    
          
                $user->notify(new OverdueBooksNotification($overdue));
                $notifiedUsers[] = $user->email;
      
    
        if (count($notifiedUsers)) {
            return redirect()->back()->with('success', 'Notifications sent to: ' . implode(', ', $notifiedUsers).'where id '.$id);
        }
        
        return redirect()->back()->with('info', 'No users found.');
    }
}
