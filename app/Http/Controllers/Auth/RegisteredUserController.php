<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Librarian;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Log;

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
            //'phone' => ['required', 'string', 'max:20'],
            'phone' =>['required', 'string', 'max:25', 'unique:' . User::class],
            'address' => ['nullable', 'string'],
            'role' => ['required', 'in:admin,librarian,student'],
            'img' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'student_id'=>['required', 'string', 'max:255', 'unique:' . Student::class],

        ]);

        try {
            $imageName = time() . '.' . $request->img->extension();
            $path = $request->file('img')->storeAs('images', $imageName, 'public');

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'role' => $request->role,
                'is_active' => $request->is_active ?? false,
                'img' => $path,
                'password' => Hash::make($request->password),
            ]);

            event(new Registered($user));

            if ($request->role == 'librarian') {
                Librarian::create([
                    'id' => $user->id,
                    'employee_id' => $request->employee_id,
                    'designation' => $request->designation,
                    'specialization' => $request->specialization,
                ]);
            } elseif ($request->role == 'student') {
               $student =  Student::create([
                    'id' => $user->id,
                    'student_id' => $request->student_id,
                    'department' => $request->department,
                    'year' => $request->year,
                    'semester' => $request->semester,
                ]);
                if(!$student)
                {
                    $user->delete();
                }
            }

            

            Auth::login($user);
            return redirect()->route($user->role === 'student' ? 'student.dashboard' : 'admin');
        } catch (\Exception $e) {
            Log::error('Registration Error: ' . $e->getMessage());

            return redirect()->back()->withInput()->withErrors([
                'registration_error' => 'Something went wrong during registration. Please try again.'
            ]);
        }
    }
}
