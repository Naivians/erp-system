<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PosController extends Controller
{

    public function showCategory($category)
    {
        $products = DB::table('products')->where('category', $category)->get();
        return response()->json($products);
    }

    public function addToSession(Request $request)
    {
        $request->session()->push('products', $request->product);
        return response()->json(['success' => true]);
    }

    // app/Http/Controllers/ProductController.php
    public function getSessionData(Request $request)
    {
        return response()->json($request->session()->get('products', []));
    }

    public function saveOrders(Request $request)
    {
        $orderData = $request->input('order');

        // Prepare data for insertion
        $insertData = [];
        foreach ($orderData as $item) {
            $insertData[] = [
                'product_name' => $item['product_name'],
                'category' => $item['category'],
                'price' => $item['price'],
                'created_at' => now(), // assuming you want to add timestamps
                'updated_at' => now(),
            ];
        }

        // Insert data into the orders table using query builder
        DB::table('orders')->insert($insertData);

        // Clear the session data
        Session::forget('orders');

        return response()->json(['status' => 'success']);
    }

    public function clearSession(Request $request)
    {
        // Clear the session data
        Session::forget('session_data');

        return response()->json(['success' => true]);
    }
}
