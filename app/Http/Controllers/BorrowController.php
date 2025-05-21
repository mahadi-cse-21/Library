<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Book_Copy;
use App\Models\Borrow;
use App\Models\Fine;
use App\Models\Requests;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        //
        $borrows = Borrow::with('student', 'book',)->paginate(5);

        $returnbook = Borrow::where('status', 'returned')
            ->whereDate('return_date', Carbon::today())
            ->count();
        $activeborrow = Borrow::where('status', 'borrowed')->count();

        $duetoday = Borrow::where('status', 'borrowed')
            ->whereDate('due_date', Carbon::today())
            ->count();

        $overdueBooks = Borrow::where('due_date', '<', Carbon::today())
            ->whereNull('return_date')
            ->count();


        return view('admin.borrows', [
            'borrows' => $borrows,
            'returnbook' => $returnbook,
            'duetoday' => $duetoday,
            'activeborrow' => $activeborrow,
            'overduebooks' => $overdueBooks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($user, $id)
    {
        // Ensure the student exists
        $student = Student::find($user);
        if (!$student) {
            return back()->with('error', 'Invalid student.');
        }

        // Check for duplicate request
        $existingRequest = Requests::where('student_id', $user)
            ->where('book_id', $id)
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {
            return back()->with('error', 'You already have a pending request for this book.');
        }

        // Find an available copy of the book
        $availableCopy = Book::where('id', $id)
            ->where('status', 'available')
            ->where('available_quantity', '>', 0)
            ->first();

        if (!$availableCopy) {
            return back()->with('error', 'No available copy for this book.');
        }

        try {
            $requests =  Requests::create([
                'student_id' => $user,
                'book_id' => $availableCopy->id,
                'type' => 'request',
                'status' => 'pending',
                'requested_date' => Carbon::today(),
            ]);




            // Optional: update book availability
            $availableCopy->decrement('available_quantity');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to insert request: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Book request submitted successfully.');
    }







    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Borrow  $borrow
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        // Eager load related data

        $borrow = Borrow::findOrFail($id);
        
        
        $borrow->load([
            'student.user',
            'book', // Nested: book copy and its book
            
        ]);
        $overdues_book = Borrow::where('status', 'borrowed')
        ->where('due_date', '<', Carbon::today())
        ->where('student_id', $borrow->student->id)
        ->whereNull('return_date')
        ->count();

        

        return view('admin.show', compact('borrow','overdues_book'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Borrow  $borrow
     * @return \Illuminate\Http\Response
     */
    public function edit(Borrow $borrow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Borrow  $borrow
     * @return \Illuminate\Http\Response
     */



    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $user = Auth::user();

            // Ensure the user is a librarian
            if ($user->role !== 'librarian') {
                return redirect()->back()->with('error', 'Unauthorized action.');
            }

            $borrow = Borrow::findOrFail($id);
            $borrow->status = 'returned';
            $borrow->received_by_librarian_id = $user->id;
            $borrow->return_date = Carbon::today();
            $borrow->save();

            // Decrease student's current borrows
            $student = Student::find($borrow->student_id);
            $student->decrement('current_borrows');
            $student->save();


            // Update related request if exists
            $book = Book::find($borrow->book_id);
            $requestEntry = Requests::where('book_id', $book->id)
                ->where('student_id', $borrow->student_id)
                ->where('status', 'approved')
                ->first();

            if ($requestEntry) {
                $requestEntry->status = 'completed';
                $requestEntry->save();

                if ($book) {
                    $book->increment('available_quantity');
                    $book->save();
                }
            }


            DB::commit();

            return redirect()->back()->with('success', 'Book returned successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to return the book. Please try again.');
        }
    }





    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Borrow  $borrow
     * @return \Illuminate\Http\Response
     */
    public function destroy(Borrow $borrow)
    {
        //
    }
}
