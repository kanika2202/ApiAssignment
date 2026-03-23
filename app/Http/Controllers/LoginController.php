<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\login;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function index(){
        return view('login');
    }

    public function save(Request $request){
        $login=new login();
        $login->name=$request->input('name');
        $login->password=$request->input('password');
        $login->save();

        return redirect('/logins');
    }
}
