<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stockin;
use App\Models\Category;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Inventory;
use Illuminate\Support\Facades\Cache;


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

    function stocklist()
    {
        return view('admin.stocklist', ['stockins' => Stockin::paginate(10)]);
    }


    function destroy($id)
    {
        $stocks = Stockin::findOrFail($id);
        $stocks->delete();

        if (!$stocks) {
            return redirect()->back()->with('error', 'Failed to save record');
        }

        return redirect()->route('Admins.InventoryStockList')->with('success', 'Successfully deleted item');
    }


    function edit($id)
    {
        try {
            $stocks = Stockin::findOrFail($id);
            return view('admin.stocklist', ['item' => $stocks, 'edited' => true, 'stockins' => Stockin::paginate(10)]);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Item ID does not exist');
        }
    }


    function update(Request $request)
    {

        if ($request->stocks == null) {
            return redirect()->back()->with('error', 'All fields required');
        }

        $price = (float) $request->price;
        $total = (float) ($request->stocks * $price);

        $update = Stockin::where('id', $request->id)->update(
            [
                'total_amount' => $total,
                'stocks' => $request->stocks,
                'created_at' => now(),
            ]
        );


        if (!$update) {
            return redirect()->back()->with('error', 'Failed to update item');
        }
        return redirect()->route('Admins.InventoryStockList')->with('success', 'Successfully update item');
    }
}
