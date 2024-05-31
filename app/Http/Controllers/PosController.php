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

        // Generate the receipt
        $receipt = view('user.receipt', [
            'orderData' => $orderData,
            'orderId' => $order_id,
            'total' => array_sum(array_column($orderData, 'price')),
            'date' => now(),
        ])->render();

        return response()->json([
            'success' => true,
            'receipt' => $receipt,
        ]);
    }

    public function printReceipt($orderId)
    {
        $orders = DB::table('orders')->where('order_id', $orderId)->get();

        $total = $orders->sum('price');

        $receipt = view('user.receiptTransaction', [
            'orderData' => $orders,
            'orderId' => $orderId,
            'total' => $total,
            'date' => now(),
        ])->render();

        return response()->json([
            'success' => true,
            'receipt' => $receipt,
        ]);
    }


    public function getOrders(Request $request)
    {
        // Get the date range from the request
        $dateFrom = $request->input('dateFrom') ?? date('Y-m-d');
        $dateTo = $request->input('dateTo') ?? date('Y-m-d');

        // Calculate order count
        $orderCountQuery = DB::table('orders')->distinct('order_id');

        // Calculate product count
        $productCountQuery = DB::table('orders')->distinct('id');

        // Calculate total sales
        $totalSalesQuery = DB::table('orders')
            ->select(DB::raw('SUM(price * QTY) as total_sales'));

        // If date filters are set, add them to the queries
        if ($dateFrom && $dateTo) {
            $orderCountQuery->whereDate('created_at', '>=', $dateFrom)
                ->whereDate('created_at', '<=', $dateTo);

            $productCountQuery->whereDate('created_at', '>=', $dateFrom)
                ->whereDate('created_at', '<=', $dateTo);

            $totalSalesQuery->whereDate('created_at', '>=', $dateFrom)
                ->whereDate('created_at', '<=', $dateTo);
        }

        $orderCount = $orderCountQuery->count('order_id');
        $productCount = $productCountQuery->count('product_name');
        $totalSales = $totalSalesQuery->first()->total_sales;

        // Get all orders
        // Start building the query
        $query = DB::table('orders')
            ->select(
                DB::raw('DATE(created_at) as created_at'),
                'order_id',
                'product_name',
                'QTY',
                DB::raw('SUM(price) as total_price')
            )
            ->groupBy('order_id', 'created_at', 'product_name', 'QTY')
            ->orderBy('order_id', 'desc');

        // If date filters are set, add them to the query
        if ($dateFrom && $dateTo) {
            $query->whereDate('created_at', '>=', $dateFrom)
                ->whereDate('created_at', '<=', $dateTo);
        }

        // Execute the query
        $orders = $query->get();

        // Group orders by order_id
        $grouped = $orders->groupBy('order_id');

        return view('user.transactionHistory', [
            'groupedOrders' => $grouped,
            'orderCount' => $orderCount,
            'productCount' => $productCount,
            'totalSales' => $totalSales
        ]);
    }
}
