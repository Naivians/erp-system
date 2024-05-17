<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

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
        Log::info('Orders received:', $request->all());

        $orders = $request->input('orders');

        foreach ($orders as $order) {
            Log::info('Saving order:', $order);

            DB::table('orders')->insert([
                'product_name' => $order['product_name'],
                'code' => $order['code'] ?? null,
                'category' => $order['category'] ?? null,
                'description' => $order['description'] ?? null,
                'price' => $order['price'],
                'QTY' => $order['quantity'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json(['message' => 'Orders saved successfully']);
    }


    public function clearSession(Request $request)
    {
        Log::info('Session before clearing:', $request->session()->all());

        $request->session()->forget('orders');

        Log::info('Session after clearing:', $request->session()->all());

        return response()->json(['message' => 'Session cleared successfully']);
    }
}
