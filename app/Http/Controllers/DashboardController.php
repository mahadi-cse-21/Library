<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Requests;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function index()
    {
        // Total Books
        $total_books = Book::all()->count();

        // Borrowed Books Today (example)
        $borrowed_today = Borrow::whereDate('created_at', Carbon::today())->count();

        $books_borrowed = DB::table('borrows')
            ->join('students', 'borrows.student_id', '=', 'students.id')
            ->join('users', 'users.id', '=', 'students.id')
            
            ->join('books', 'book_id', '=', 'books.id')
            ->select('users.name as student_name', 'books.title as book_title', 'borrows.created_at')
            ->orderBy('borrows.created_at', 'desc')
            ->limit(5)
            ->get();



        //    dd($books_borrowed_recently);
        // Overdue Books
        $overdue_book_total = Borrow::where('due_date', '<', Carbon::today())
            ->whereNull('return_date') // assuming 'returned_at' is the column indicating return
            ->count();

        $overdue_books = Borrow::where('due_date', '<', Carbon::today())
            ->whereNull('return_date')
            ->with('student.user', 'book_copy.book')
            ->paginate(10); // or any number of items per page

            // dd($overdue_books);
        // Pending Returns (books that are borrowed but not yet returned)


        $pending_returns = Borrow::where('due_date', '>', Carbon::today())
            ->whereNull('return_date')->count();

        $requests = Requests::with('student', 'book')
            ->where('status', 'pending')
            ->get();

        return view('admin.dashboard', [
            'total_books' => $total_books,
            'borrowed_today' => $borrowed_today,
            'books_borrowed' => $books_borrowed,
            'requests' => $requests,
            'overdue_book_total' => $overdue_book_total,
            'pending_returns' => $pending_returns,
            'overdue_books' => $overdue_books,
        ]);
    }
}
