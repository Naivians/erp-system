<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    function index()
    {
        return view('index');
    }

    function adminHome()
    {
        return view('admin.dashboard');
    }

    public function userPos (){
        return view('user.POS');
    }
}
