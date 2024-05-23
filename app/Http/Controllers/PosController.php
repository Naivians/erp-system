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

        // Generate a new order_id
        $order_id = DB::table('orders')->max('order_id') + 1;

        // Process the order data and save it to the 'orders' table
        foreach ($orderData as $item) {
            $product = DB::table('products')->where('product_name', $item['product_name'])->first();

            DB::table('orders')->insert([
                'order_id' => $order_id,
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


    public function getOrders()
    {
        // Get all orders
        $orders = DB::table('orders')
            ->select(DB::raw('DATE(created_at) as created_at'), 'order_id', 'product_name', 'QTY', DB::raw('SUM(price * QTY) as total_price'))
            ->groupBy('order_id', 'created_at', 'product_name', 'QTY')
            ->orderBy('order_id', 'desc')
            ->get();

        // Group orders by order_id
        $grouped = $orders->groupBy('order_id');

        // Manually paginate the results
        $perPage = 5;
        $currentPage = request()->get('page', 1);
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $grouped->forPage($currentPage, $perPage),
            $grouped->count(),
            $perPage,
            $currentPage
        );

        return view('user.transactionHistory', ['groupedOrders' => $paginator]);
    }
}
