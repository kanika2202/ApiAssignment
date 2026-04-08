<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index() {
        return view('register');
    }

    public function store(Request $request) {
        // ១. Validate ទិន្នន័យ
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:3|confirmed', // ត្រូវវាយ password ២ដងឱ្យដូចគ្នា
        ]);

        // ២. បង្កើត User ថ្មី (កំណត់ Role ជា user ជាស្វ័យប្រវត្តិ)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', 
        ]);

        // ៣. Login ចូលភ្លាមៗក្រោយចុះឈ្មោះរួច
        Auth::login($user);

        return redirect('/')->with('success', 'ចុះឈ្មោះជោគជ័យ!');
    }
    public function List() {
        $users = User::latest()->get();
        return view('user_list', compact('users'));
    }
}