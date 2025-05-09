<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\Fine;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class FineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $borrows= Borrow::where('due_date','<',Carbon::today())
        ->whereNull('return_date')
        ->get();

        foreach ($borrows as $borrow) {
            $fineExists = Fine::where('borrow_id', $borrow->id)
            ->exists();
            if (!$fineExists) {
                Fine::create([
                    'borrow_id' => $borrow->id,
                    'student_id' => $borrow->student_id,
                    'amount' => 10.00, // Standard damage fee
                    'reason' => "Book returned in condition: ", // Note: message incomplete
                    'is_paid' => false,
                ]);
            }
        }
        $total_outstandings = Fine::where('is_paid', false)->sum('amount');


        $this_month = Fine::whereBetween('paid_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth()
        ])
        ->where('is_paid', true)
        ->sum('amount');

        $student_with_fines = Fine::count();

        $fines = Fine::with(['borrow.book_copy.book', 'student.user', 'librarian'])->get();
        
        // dd($fines);

        return view('admin.fines', [
            'fines'=>$fines,
            'total_outstandings'=>$total_outstandings,
            'this_month'=>$this_month,
            'student_with_fines'=>$student_with_fines,


        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $borrows = Borrow::with('student')->whereNull('returned_at')
        ->where('due_date','<',Carbon::today())
        ->get();
        $students = Student::all();
        return view('admin.fines.create', compact('borrows', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'borrow_id' => 'required|exists:borrows,id',
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:0',
            'reason' => 'required|string|max:255',
        ]);
        
        Fine::create($validated);
        
        return redirect()->back()->with('success', 'Fine created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fine  $fine
     * @return \Illuminate\Http\Response
     */
    public function show(Fine $fine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fine  $fine
     * @return \Illuminate\Http\Response
     */
    public function edit(Fine $fine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fine  $fine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fine $fine)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fine  $fine
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fine $fine)
    {
        //
    }
}
