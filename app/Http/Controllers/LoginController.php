<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index() {
        return view('login'); // ត្រូវប្រាកដថាឈ្មោះ File គឺ login.blade.php
    }

    public function save(Request $request) {
        $identity = $request->input('identity');
        $password = $request->input('password');

        // ឆែកថាជា Email ឬជា Name
        $fieldType = filter_var($identity, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        if (Auth::attempt([$fieldType => $identity, 'password' => $password])) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/categoryList');
            }
            return redirect('/');
        }

        return back()->withErrors(['identity' => 'ព័ត៌មានមិនត្រឹមត្រូវ!'])->withInput();
    }
     

}