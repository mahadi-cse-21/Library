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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
    // Common validation rules for all user types
    $commonRules = [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'phone' => ['required', 'string', 'max:25', 'unique:users'],
        'address' => ['nullable', 'string', 'max:500'],
        'role' => ['required', 'in:librarian,student'],
        'img' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:2048'], // Changed to nullable
        'password' => ['required', 'string', 'min:8', 'confirmed', Rules\Password::defaults()],
    ];

    // Role-specific validation rules
    $roleRules = [
        'student' => [
            'student_id' => ['required', 'string', 'max:20', 'unique:students,student_id'], // Fixed unique rule
            'department' => ['required', 'string', 'max:100'],
            'year' => ['required', 'string', 'max:20'],
            'semester' => ['required', 'string', 'max:20'],
        ],
        'librarian' => [
            'employee_id' => ['required', 'string', 'max:20', 'unique:librarians,employee_id'], // Fixed unique rule
            'designation' => ['required', 'string', 'max:100'],
            'specialization' => ['required', 'string', 'max:100'],
        ],
    ];

    // Determine which role-specific rules to apply
    $validationRules = $commonRules;
    if ($request->has('role') && isset($roleRules[$request->role])) {
        $validationRules = array_merge($validationRules, $roleRules[$request->role]);
    }

    // Validate request
    $validatedData = $request->validate($validationRules);

    DB::beginTransaction();

    try {
        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('img') && $request->file('img')->isValid()) {
            $imageName = time() . '_' . uniqid() . '.' . $request->img->extension();
            $imagePath = $request->file('img')->storeAs('images', $imageName, 'public');
        }

        // Create user
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'] ?? null,
            'role' => $validatedData['role'],
            'is_active' => true, // Default to active user
            'img' => $imagePath,
            'password' => Hash::make($validatedData['password']),
        ]);

        // Create role-specific record
        if ($validatedData['role'] === 'librarian') {
            Librarian::create([
                'id' => $user->id, // Changed from 'id' to 'user_id' to match foreign key convention
                'employee_id' => $validatedData['employee_id'],
                'designation' => $validatedData['designation'],
                'specialization' => $validatedData['specialization'],
            ]);
        } elseif ($validatedData['role'] === 'student') {
            Student::create([
                'id' => $user->id, // Changed from 'id' to 'user_id' to match foreign key convention
                'student_id' => $validatedData['student_id'],
                'department' => $validatedData['department'],
                'year' => $validatedData['year'],
                'semester' => $validatedData['semester'],
            ]);
        }

        // Fire registered event
        event(new Registered($user));
        
        DB::commit();

        // Log in the new user
        Auth::login($user);

        // Redirect based on role
        return redirect()->route(
            $user->role === 'student' ? 'student.dashboard' : 'admin'
        )->with('success', 'Registration successful! Welcome to our library system.');

    } catch (\Exception $e) {
        DB::rollBack();

        // Clean up the uploaded file if it exists
        if (isset($imagePath) && $imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }

        Log::error('Registration Error: ' . $e->getMessage(), [
            'email' => $request->email ?? 'not provided',
            'role' => $request->role ?? 'not provided',
            'trace' => $e->getTraceAsString()
        ]);

        // Debug logging - only in development
        if (config('app.debug')) {
            Log::debug('Registration Error Details: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_data' => $request->except(['password', 'password_confirmation'])
            ]);
        }

        return redirect()->back()
            ->withInput()
            ->withErrors([
                'registration_error' => 'An error occurred during registration: ' . ($e->getMessage() && config('app.debug') ? $e->getMessage() : 'Please try again or contact support.')
            ]);
    }
}
}
