<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function getItemsByCategory($category)
    {
        $category = strtolower($category);
        $items = DB::table('Products')->where('category', $category)->get();
        return response()->json($items);
    }

}
