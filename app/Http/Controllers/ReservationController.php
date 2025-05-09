<?php

namespace App\Http\Controllers;

use App\Models\Requests;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        //
        $reservations = Reservation::with('student.user', 'book')->get();


        $mostReservedBooks = Reservation::select('book_id', DB::raw('COUNT(*) as total'))
            ->with('book.category') // eager load book and its category
            ->groupBy('book_id')
            ->orderByDesc('total')
            ->take(4)
            ->get();
        $total_reservations = Reservation::count();

        $active_reservatins = Reservation::where('status','active')->count();

        $expired_reservations = Reservation::where('expiry_date','<',Carbon::today())->count();

        $converted_to_borrowed = Reservation::where('status','confirmed')->count();

        


        return view('admin.reservation', [
            'reservations' => $reservations,
            'mostReservedBooks' => $mostReservedBooks,
            'total_reservations'=>$total_reservations,
            'expired_reservations'=>$expired_reservations,
            'active_reservations'=>$active_reservatins,
            'converted_to_borrowed'=>$converted_to_borrowed,

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
        return view('browse.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // $request->validate([
        //     'student_id' => ['required', 'integer', 'exists:students,id'],
        //     'book_id' => ['required', 'integer', 'exists:books,id'],
        //     'reservation_date' => ['required', 'date'],
        //     'expiry_date' => ['nullable', 'date'],
        //     'status' => ['required', 'in:confirm,pending,cancel,completed'],
        // ]);

        $reservation = Reservation::create([
            'student_id' => auth()->user()->id,
            'book_id' => $request->book_id,
            'reservation_date' => Carbon::now(),
            'expiry_date' => Carbon::now()->addDays(7),
            'status' => 'pending',
        ]);




        return redirect()->back()->with('success', 'Reservation created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}
