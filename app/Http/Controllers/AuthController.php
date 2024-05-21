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
            $request->session()->put('user', $user);

            if($user->role == 1){
                return redirect()->route('Admins.InventoryHome');
            }else{
                return redirect()->route('Users.POS');
            }
        } else {
            return redirect()->back()->with('error', 'username and password is incorrect');
        }


    }


    function logout(Request $request){
        $request->session()->forget('user');
        $request->session()->regenerate();
        return redirect()->route('login');
    }
}
