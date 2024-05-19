<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function userPOS (){
        $products = DB::table('products')
        ->distinct()
        ->get();

        $categories = DB::table('products')
        ->select('category')
        ->distinct()
        ->get();

        // Pass the data to the view
        return view('user.POS', compact('products', 'categories'));
    }
}
