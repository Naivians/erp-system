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
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $stockins = Stockin::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->paginate(5);
        return view('admin.stockin', ['stockins' => $stockins, 'categories' => Category::all()]);
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

        $date_today = Carbon::now()->toDateString();


        foreach ($categories as $index => $category) {

            $is_exist = Inventory::where('code', $codes[$index])
                ->whereDate('created_at', $date_today)
                ->exists();
            if ($is_exist) {
                return response()->json([
                    'status' => 404,
                    'message' => 'You are not allowed to restock this code since you just inserted it today to the masterlist. In order to proceed please remove this code and update it later or by the next day.'
                ]);
            }
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

            $inventory = Inventory::where('code', $codes[$index])->first();

            $end_env = ($inventory->stockin + $stocks[$index]) - $inventory->stockout;
            $total_amount = $end_env * $inventory->price;

            Inventory::where('code', $codes[$index])->update([
                'end_inv' =>  $end_env,
                'total_amount' => $total_amount
            ]);
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

        if (!$stocks) {
            return redirect()->back()->with('error', 'Failed to save record');
        }

        $is_beginning = Inventory::where('code', $stocks->code)
            ->whereDate('created_at', $stocks->created_at)
            ->exists();

        if ($is_beginning) {
            return redirect()->route('Admins.InventoryStockList')->with('warning', 'You are not allowed to delete this item since your beginning inventory is anchored to this code but, if you meant to delete or move it to waste then go to checklist table and do the operation needed to be done.');
        } else {
            $res = Inventory::where('code', $stocks->code)->first();

            $newEnv = $res->end_inv - $stocks->stocks;


            Inventory::where('code', $stocks->code)->update([
                'end_inv' => $newEnv,
                'total_amount' => $newEnv * $res->price,
            ]);
            $stocks->delete();
            return redirect()->route('Admins.InventoryStockList')->with('success', 'Successfully delete item');
        }
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


        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        $totalStockins = 0;

        $stocks = Stockin::where('id', $request->id)->first();
        $inventory = Inventory::where('code', $stocks->code)->first();

        if ($request->stocks != $request->old_stocks) {
            $stockins = Stockin::where('code', $stocks->code)
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)
                ->get();




            foreach ($stockins as $stocks) {
                $totalStockins  += $stocks->stocks;
            }

            // dd((($request->stocks - $request->old_stocks) + $totalStockins) - $inventory->stockout);

            $newStocks = (($request->stocks - $request->old_stocks) + $totalStockins) - $inventory->stockout;

            // dd( 'New Stoacaks: '. $request->stocks . ' old stocks: ' . $request->old_stocks . ' New stocks: '.  $newStocks . ' Stockut: '. $inventory->stockout . ' Ending :' .(($request->stocks - $request->old_stocks) + $totalStockins) - $inventory->stockout); // 3

            $update = Inventory::where('code', $stocks->code)->update(
                [
                    'end_inv' => (($request->stocks - $request->old_stocks) + $totalStockins) - $inventory->stockout,
                    'total_amount' => $total,
                    'stockin' => (($request->stocks - $request->old_stocks) + $totalStockins) - $inventory->stockout,
                ]
            );

            $update = Stockin::where('id', $request->id)->update(
                [
                    'total_amount' => $total,
                    'stocks' => $request->stocks,
                    'updated_at' => now(),
                ]
            );

            return redirect()->route('Admins.InventoryStockList')->with('success', 'Successfully update item');
        } else {
            return redirect()->route('Admins.InventoryStockList')->with('warning', 'NO changes has been made');
        }
    }
}
