<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    function index()
    {
        return view('index');
    }

    function userHome()
    {
        return view('user.index');
    }

    function adminHome()
    {
        return view('admin.dashboard');
    }
}
