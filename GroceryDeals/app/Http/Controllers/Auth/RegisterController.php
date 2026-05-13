<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * Validation is handled by StoreUserRequest.
     * MongoDB unique email check is done inside the Form Request
     * because Laravel's built-in unique:users requires SQL.
     */
    public function register(StoreUserRequest $request)
    {
        // $request->validated() returns only the validated fields
        $validated = $request->validated();

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Registration successful!');
    }
}
