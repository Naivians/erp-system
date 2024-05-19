<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function showProductsByCategory($category)
    {
        $products = DB::table('products')
            ->where('category', $category)
            ->get();

        return response()->json($products);
    }

    public function updateSession(Request $request)
    {
        $orderData = $request->input('order');
        $request->session()->put('currentOrder', $orderData);

        return response()->json(['success' => true]);
    }

    public function getSessionData(Request $request)
    {
        $orderData = $request->session()->get('currentOrder', []);
        return response()->json($orderData);
    }

    public function placeOrder(Request $request)
    {
        // Retrieve the order data from the request
        $orderData = $request->input('order');

        // Process the order data and save it to the 'orders' table
        foreach ($orderData as $item) {
            $product = DB::table('products')->where('product_name', $item['product_name'])->first();

            DB::table('orders')->insert([
                'product_name' => $item['product_name'],
                'code' => $product->code,
                'category' => $product->category,
                'price' => $item['price'],
                'QTY' => $item['quantity'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Clear the session data
        $request->session()->forget('currentOrder');

        return response()->json(['success' => true]);
    }
}
