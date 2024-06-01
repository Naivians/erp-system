<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stockin;
use App\Models\Stockout;
use App\Models\Category;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Inventory;
use Illuminate\Support\Facades\Cache;

class StockoutController extends Controller
{
    function index()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $stockins = Stockout::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->paginate(5);

        return view('admin.stockout_list', ['stockouts' =>$stockins]);
    }

    function formPage()
    {
        return view('admin.stockout_form', ['stockins' => Stockin::paginate(10), 'categories' => Category::all()]);
    }

    function destroy($id)
    {
        $stocks = Stockout::findOrFail($id);

        if (!$stocks) {
            return redirect()->back()->with('error', 'Failed to save record');
        }

        $res = Inventory::where('code', $stocks->code)->first();

        $newEnv = $stocks->stocks + $res->end_inv;
        $newStockout = $res->stockout - $stocks->stocks;

        Inventory::where('code', $stocks->code)->update([
            'end_inv' => $newEnv,
            'total_amount' => $newEnv * $res->price,
            'stockout' =>  $newStockout
        ]);

        $stocks->delete();

        return redirect()->route('Admins.InventoryStockoutList')->with('success', 'Successfully deleted item');
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
                'message' => "Try to input some item or click refresh"
            ]);
        }

        $data = [];
        $stockin = true;
        $balance = true;

        foreach ($categories as $index => $category) {

            $inventory = Inventory::where('code', $codes[$index])->first();

            $newStockout = $inventory->stockout + $stocks[$index];


            // also check if the total stockout > stockins PS: this is error

            if ($newStockout > $inventory->stockin) {
                return response()->json([
                    'message' => 'Insuffient Balance: Stock in: ' . $inventory->stockin . ' Stock out: ' . $inventory->stockout,
                    'status' => 500,
                ]);
            }

            // $balance = false;
            // can stockin
        }

        if ($stockin) {
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

                $end_env = $inventory->stockin - ($inventory->stockout + $stocks[$index]);
                $total_amount = $end_env * $prices[$index];

                Inventory::where('code', $codes[$index])->update([
                    'end_inv' => $end_env,
                    'total_amount' => $total_amount
                ]);
            }

            try {
                Stockout::insert($data); // Batch insert
                Session::forget('products');

                return response()->json([
                    'status' => 200,
                    'message' => 'Successfully added stocks',
                    'url' => route('Admins.InventoryStockoutList')
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 500,
                    'message' => $e->getMessage(),
                ]);
            }
        }
    }

    function edit($id)
    {
        try {
            $stocks = Stockout::findOrFail($id);
            return view('admin.stockout_list', ['item' => $stocks, 'edited' => true, 'stockouts' => Stockin::paginate(10)]);
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


        $stocks = Stockout::where('id', $request->id)->first();
        $inventory = Inventory::where('code', $stocks->code)->first();

        $update = Stockout::where('id', $request->id)->update(
            [
                'total_amount' => $total,
                'stocks' => $request->stocks,
                'updated_at' => now(),
            ]
        );



        if (!$update) {
            return redirect()->back()->with('error', 'Failed to update item');
        }

        // update end inv
        Inventory::where('code', $stocks->code)->update(
            [
                'end_inv' =>  $inventory->stockin - $request->stocks,
                'total_amount' => $total,
            ]
        );



        return redirect()->route('Admins.InventoryStockoutList')->with('success', 'Successfully update item');
    }
}
