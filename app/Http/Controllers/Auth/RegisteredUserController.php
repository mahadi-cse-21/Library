<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Librarian;
use App\Models\Student;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'role' => ['required', 'in:admin,librarian,student'],
            'img' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

       
        
        $imageName = time().'.'.$request->img->extension();  
        $path = $request->file('img')->storeAs('images', $imageName, 'public');
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => $request->role,
            'is_active' => $request->is_active,
            'img' => $path,
            'password' => Hash::make($request->password),
        ]);
        



        event(new Registered($user));


        if ($request->role == 'librarian') {

            $librarian = new Librarian;
            $librarian->id = $user->id;
            $librarian->employee_id = $request->employee_id;
            $librarian->designation = $request->designation;
            $librarian->specialization = $request->specialization;

            $librarian->save();
        } else if ($request->role == 'student') {

            $student = new Student;
            $student->id = $user->id;
            // $student->id = User::where('name', $user->name)->first()->id;
            $student->student_id = $request->student_id;
            $student->department = $request->department;
            $student->year = $request->year;

            $student->semester = $request->semester;

            $student->save();
        }



        Auth::login($user);
        if ($user->role === 'admin' || $user->role === 'librarian') {
            return redirect()->route('admin');
        } else {
            return redirect()->route('student.dashboard');
        }
    }
}
