<?php

namespace App\Http\Controllers;

use App\Mail\Mail as MailMail;
use App\Mail\SendMail;
use App\Models\Activity;
use App\Models\Book;
use App\Models\Book_Copy;
use App\Models\Borrow;
use App\Models\Requests;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\CssSelector\XPath\Extension\FunctionExtension;

class RequestsController extends Controller
{
    //

    public function approve($id)
    {
        DB::beginTransaction();

        try {

            $request = Requests::findOrFail($id);

            $book = Book::find($request->book_id);
            if (!$book || $book->available_quantity <= 0 || $book->status !== 'available') {
                return redirect()->route('admin')->with('Failed', 'Book is not available right now.');
            }

            // Update request status
            $request->status = 'approved';
            $request->save();

            // Create borrow record
            $borrow = Borrow::create([
                'student_id' => $request->student_id,
                'book_id' => $book->id, // Assuming `book_id` exists in your `borrows` table
                'issue_date' => Carbon::today(),
                'due_date' => Carbon::today()->addDays(7),
                'status' => 'borrowed',
                'issued_by_librarian_id' => Auth::user()->id,
            ]);

            // Update book availability
            $book->available_quantity = max(0, $book->available_quantity - 1);
            if ($book->available_quantity == 0) {
                $book->status = 'stock out';
            }
            $book->save();

            // Update student record
            $student = Student::find($request->student_id);
            if ($student) {
                $student->book_borrowed += 1;
                $student->current_borrows += 1;
                $student->save();
            }
            Activity::log(
                'approve_request',
                'Request approved and book issued to student.',
                Auth::id(),
                $book->id,
                $student->id ?? null,
                [
                    'request_id' => $request->id,
                    'borrow_id' => $borrow->id,
                    'issue_date' => $borrow->issue_date->toDateString(),
                    'due_date' => $borrow->due_date->toDateString(),
                ]
            );

            DB::commit();
            $details = [
                'request' => $request,
                'book' => $book,
                'borrow' => $borrow,
                'student' => $student,
            ];

           Mail::to($request->student->user->email)->send(new SendMail($details, 'Request Approved'));

            return redirect()->route('admin')->with('status', 'Request Approved');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin')->with('Failed', 'Error: ' . $e->getMessage());
        }
    }


    // Method to reject a request
   public function reject($id)
{
    try {
        $request = Requests::with('student.user', 'book')->findOrFail($id);

        $request->status = 'rejected';
        $request->save();

        // Log activity
        Activity::log(
            'reject_request',
            'Request was rejected by librarian.',
            Auth::id(),
            $request->book_id,
            $request->student_id,
            [
                'request_id' => $request->id,
            ]
        );

        // Prepare data for email
        $details = [
            'request' => $request,
            'book' => $request->book,
            'student' => $request->student,
            'status' => 'rejected',
        ];

        Mail::to($request->student->user->email)->send(new SendMail($details, 'Request Rejected'));

        return redirect()->route('admin')->with('status', 'Request Rejected and email sent.');
    } catch (\Exception $e) {
        return redirect()->route('admin')->with('Failed', 'Error: ' . $e->getMessage());
    }
}

}
