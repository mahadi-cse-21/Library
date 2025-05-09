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
        $borrows = Borrow::with('student', 'book_copy.book',)->paginate(5);

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
            'overduebooks'=> $overdueBooks,
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
    public function store(Request $request, $id, $book_copy_id)
    {
        
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        if (!Student::find($id))
         {
            return back()->with('error', 'Invalid student.');
        }

        if (!Book_Copy::find($book_copy_id))
         {
            return back()->with('error', 'Invalid book copy.');
        }


        // Find an available copy of the book
        $availableCopy = Book_Copy::where('book_id', $validated['book_id'])
            ->where('status', 'available')
            ->first();

        if (!$availableCopy) {
            return back()->with('error', 'No available copy for this book.');
        }

        // Create request entry
        try {
            Requests::create([
                'student_id' => $id,
                'book_copy_id' => $availableCopy->book_copy_id,
                'type' => 'request',
                'status' => $request->status,
                'requested_date'=>Carbon::today(),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to insert request: ' . $e->getMessage());
        }


        // Update book copy status
        //$availableCopy->update(['status' => 'borrowed']);

        return redirect()->back()->with('success', 'Book borrowed successfully.');
    }






    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Borrow  $borrow
     * @return \Illuminate\Http\Response
     */
    public function show(Borrow $borrow)
    {
        //
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
    public function update(Request $request, Borrow $borrow)
    {

        $borrow->status = 'returned';
        $borrow->received_by_librarian_id = auth()->user()->id;
        $borrow->return_date = Carbon::today();
        $borrow->save();

        // dd($borrow);
       

        $student = Student::find($borrow->student_id);
        $student->decrement('current_borrows');
        $student->save();

        // Mark book copy as available again
        $borrow->book_copy->status = 'available';

        $borrow->book_copy->save();



       

        // Update request entry if found
        $requestEntry = Requests::where('book_copy_id', $borrow->book_copy_id)
            ->where('student_id', $borrow->student->id)
            ->where('status', 'approved')
            ->first();
        // dd($requestEntry);

        if ($requestEntry) {
            $requestEntry->status = 'completed';

            $requestEntry->save();
            $books = Book::where('id', $borrow->book_copy->book_id)->get();
            $book = $books->first();
            $book->increment('available_quantity');


            $book->save();
        }

       
        return redirect()->back()->with('success', 'Book returned successfully.');
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
