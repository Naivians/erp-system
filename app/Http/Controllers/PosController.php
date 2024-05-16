<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PosController extends Controller
{
    public function view (){
        return view('cashier.POS');
    }
}
