<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function index(){
        return view('index');
    }

    function store(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
    }

    function authUser(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // check for role number
            // 0 = user
            // 1 = admin
        } else {
            return redirect()->back()->with('error', 'username and password is incorrect');
        }


    }
}
