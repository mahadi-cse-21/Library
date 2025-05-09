<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\Fine;
use App\Models\User;
use App\Models;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentProfileController extends Controller
{
    //
    public function index()
    {
        $currently_borrowed = Borrow::where('student_id', Auth::user()->student->student_id)
            ->where('status', 'borrowed')
            ->count();


        $total_borrowed = Borrow::where('student_id', Auth::user()->student->student_id)
            ->count();

        $pending_fee = Fine::where('student_id', Auth::user()->student->student_id)
            ->where('is_paid', false)
            ->sum('amount');


        return view('student.profile', [
            'currently_borrowed' => $currently_borrowed,
            'total_borrowed' => $total_borrowed,
            'pending_fee' => $pending_fee,
        ]);
    }

    public function edit()
    {
        return view('student.edit-profile', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = Auth::user(); // remove the unnecessary new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;

        if ($request->hasFile('img')) {
            if ($user->img && Storage::disk('public')->exists($user->img)) {
                Storage::disk('public')->delete($user->img);
            }

            $path = $request->file('img')->store('profiles', 'public');
            $user->img = $path;
        }

        $user->save();

        $student = $user->student;
        $student->year = $request->year;
        $student->semester = $request->semester;
        $student->save();



        return redirect()->route('student.profile.edit')->with('success', 'Profile updated successfully.');
    }
}
