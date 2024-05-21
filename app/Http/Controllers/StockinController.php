<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stockin;
use App\Models\Category;
use Illuminate\Support\Facades\Session;

class StockinController extends Controller
{
    function index()
    {
        return view('admin.stockin', ['stockins' => Stockin::paginate(10), 'categories' => Category::all()]);
    }

    function saveForm(Request $request)
    {

        $categories = $request->category;
        $names = $request->name;
        $descriptions = $request->description;
        $codes = $request->code;
        $prices = $request->price;
        $stocks = $request->qty;

        if (is_null($categories)) {
            return response()->json([
                'status' => 404,
                'message' => 'please click refresh'
            ]);
        }

        $data = [];
        foreach ($categories as $index => $category) {
            $data[] = [
                'code' => $codes[$index],
                'category' => $category,
                'name' => $names[$index],
                'description' => $descriptions[$index],
                'price' => $prices[$index],
                'stocks' => $stocks[$index],
                'beg_inv' => 0,
                'total_amount' => $prices[$index] * $stocks[$index],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        try {
            Stockin::insert($data); // Batch insert
            Session::forget('products');
            return response()->json([
                'status' => 200,
                'message' => 'Successfully added stocks',
                'url' => route('Admins.InventoryStockList')
            ]);

            // return redirect()->route('Admins.InventoryStockList');

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }

    function stocklist(){
        return view('admin.stocklist', ['stockins' => Stockin::paginate(10)]);
    }
}
