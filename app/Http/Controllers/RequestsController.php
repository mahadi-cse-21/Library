<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Book_Copy;
use App\Models\Borrow;
use App\Models\Requests;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RequestsController extends Controller
{
    //

    public function approve($id)
    {
        $request = Requests::findOrFail($id);
        $request->status = 'approved';

        $request->save();

       // dd($request);

        $borrow = Borrow::create([
            'student_id' => $request->student_id,
            'book_copy_id' => $request->book_copy_id,
            'issue_date' => Carbon::today(),  // This will use the current timestamp
            'due_date' => Carbon::today()->addDays(7),  // Adding 7 days to the current date
            'status' => 'borrowed',
            'issued_by_librarian_id' => auth()->user()->id,
        ]);
        $borrow->save();
         $book_copy_id = $request->book_copy_id;
        

        $book_copy = Book_Copy::where('book_copy_id', $book_copy_id)->first();
 // Assuming $id is the book copy ID
        
//  dd($book_copy);
        
        if ($book_copy) {
            $book_copy->status = 'borrowed';  // Change status to 'available'
            $book_copy->save();
        }


        $book = Book::find($book_copy->book_id); // Find the book by its ID

        
            // Update specific fields
            
        $book->available_quantity = $book->available_quantity-1;
        $book->save();
            
        
        $student = Student::find($request->student_id);
        $student->book_borrowed =  $student->book_borrowed+1;
        $student->current_borrows= $student->current_borrows+1;
        $student->save();

        return redirect()->route('admin')->with('status', 'Request Approved');
    }

    // Method to reject a request
    public function reject($id)
    {
        $request = Requests::findOrFail($id);

        $book_copy = Book_Copy::find($request->book_copy_id);  // Assuming $id is the book copy ID
        if ($book_copy) {
            $book_copy->status = 'available';  // Change status to 'available'
            $book_copy->save();
        }

       
        $request->status = 'rejected';
        $request->save();

        return redirect()->route('admin')->with('status', 'Request Rejected');
    }
}
