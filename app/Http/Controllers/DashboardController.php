<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function adminHome(){
        return view('admin.dashboard');
    }
}
