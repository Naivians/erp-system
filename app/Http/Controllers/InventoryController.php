<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Stockin;
use App\Models\Stockout;
use App\Models\Inventory;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class InventoryController extends Controller
{
    function index()
    {

        $this->computeMontlyStocks();

        // Fetch data for the view
        $inventories = Inventory::paginate(3);
        $categories = Category::all();

        return view('admin.checklist', ['inventories' => $inventories, 'categories' => $categories]);
    }

    function computeMontlyStocks()
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $stockins = Stockin::select('code', DB::raw('SUM(stocks) as total_stocks'))
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->groupBy('code')
            ->get();

        // / Use a transaction to ensure atomic updates
        DB::transaction(function () use ($stockins) {
            // Update the inventory for each code based on the stockins from the stockin table
            foreach ($stockins as $res) {
                Inventory::where('code', $res->code)->update(['stockin' => $res->total_stocks]);
            }

            // Get all inventory codes
            $inventoryCodes = Inventory::pluck('code');

            // Set stockin to 0 for inventory items not updated above
            foreach ($inventoryCodes as $code) {
                if (!$stockins->contains('code', $code)) {
                    Inventory::where('code', $code)->update(['stockin' => 0]);
                }
            }
        });


        // stockout

        $stockout = Stockout::select('code', DB::raw('SUM(stocks) as total_stocks'))
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->groupBy('code')
            ->get();

        // / Use a transaction to ensure atomic updates
        DB::transaction(function () use ($stockout) {
            // Update the inventory for each code based on the stockout from the stockin table
            foreach ($stockout as $res) {
                Inventory::where('code', $res->code)->update(['stockout' => $res->total_stocks]);
            }

            // Get all inventory codes
            $inventoryCodes = Inventory::pluck('code');

            // Set stockin to 0 for inventory items not updated above
            foreach ($inventoryCodes as $code) {
                if (!$stockout->contains('code', $code)) {
                    Inventory::where('code', $code)->update(['stockout' => 0]);
                }
            }
        });


        // compute for ending inv


    }
    function store(Request $request)
    {


        if ($request->code == null || $request->name == null || $request->description == null || $request->price == null || $request->category == null || $request->beg_inv == null) {
            return redirect()->back()->with('error', 'All fields are required');
        }

        $is_exist = Inventory::where('code', $request->code)->exists();

        // do not accept if exist
        if ($is_exist) {
            return redirect()->back()->with('error', 'Product code Already exist in the masterlist');
        } else {
            // process data
            $price = (float) $request->price;
            $initial = (float) ($request->beg_inv * $price);

            $res = Inventory::create([
                'code' => strtoupper($request->code),
                'category' => $request->category,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'beg_inv' => $request->beg_inv,
                'initial' => $initial,
                'remarks' => '',
            ]);

            if (!$res) {
                return redirect()->back()->with('error', 'Failed to record data');
            }


            $stockin = Stockin::create([
                'code' => strtoupper($request->code),
                'category' => $request->category,
                'name' => $request->name,
                'description' =>  $request->description,
                'price' => $request->price,
                'stocks' => $request->beg_inv,
                'total_amount' => $request->price * $request->beg_inv,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Successfully added new record!');
        }
    }
    function destroy($code)
    {

        DB::beginTransaction();

        try {
            $res1 = DB::table('stockins')->where('code', $code)->delete();
            $res2 = DB::table('inventories')->where('code', $code)->delete();
            $res3 = DB::table('stockouts')->where('code', $code)->delete();

            if ($res1 === 0 && $res2 === 1 && $res3 === 0) {
                DB::commit();

                return response()->json([
                    'status' => 200,
                    'message' => 'Successfully deleted items from this table',
                    'url' => route('Admins.InventoryHome'),
                ]);

            } else {

                if ($res1 === 0 && $res2 === 0 && $res3 == 0) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 500,
                        'message' => 'Failed to delete item',
                    ]);
                }


                DB::commit();
                return response()->json([
                    'status' => 200,
                    'message' => 'Successfully deleted items from table: Stockin, Stockout and to this table',
                    'url' => route('Admins.InventoryHome'),
                ]);
            }
        } catch (\Exception $e) {

            // return response()->json([
            //     'status' => 500,
            //     'message' => $res1 . ' ' . $res2 ,
            // ]);

            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => 'Failed to delete item',
            ]);
        }




        // return redirect()->route('')->with('success', 'Successfully deleted item');
    }


    function edit($id)
    {
        try {
            $inventory = Inventory::findOrFail($id);
            return view('admin.checklist', ['item' => $inventory, 'edited' => true, 'inventories' => Inventory::paginate(10), 'categories' => Category::all()]);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Item ID does not exist');
        }
    }


    function update(Request $request)
    {

        $today = Carbon::today();


        $price = (float) $request->price;
        $initial = (float) ($request->beg_inv * $price);

        if ($request->code != $request->old_code) {

            $newCode = Inventory::where('code', $request->old_code)->exists();
            if ($newCode) {
                return redirect()->back()->with('error', 'Product code Already exist in the masterlist');
            }

            $update = Inventory::where('code', $request->code)->update(
                [
                    'code' => $request->code,
                    'category' => $request->category,
                    'name' => $request->name,
                    'description' => $request->description,
                    'price' => $request->price,
                    'beg_inv' => $request->beg_inv,
                    'initial' => $initial,
                ]
            );

            if (!$update) {
                return redirect()->back()->with('error', 'Failed to update item');
            }

            return redirect()->route('Admins.InventoryHome')->with('success', 'Successfully update item');
        }

        $inventory = Inventory::where('code', $request->code)->first();
        $stockin = Stockin::where('code', $request->code)
            ->whereDate('created_at', $inventory->created_at)
            ->first();


        if ($request->beg_inv != $request->old_beg_inv) {

            $currentYear = Carbon::now()->year;
            $currentMonth = Carbon::now()->month;
            $totalStockins = 0;

            $stockins = Stockin::where('code', $request->code)
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)
                ->get();


            foreach ($stockins as $stocks) {
                $totalStockins  += $stocks->stocks;
            }


            $updatedRows = Stockin::where('code', $request->code)
                ->whereDate('created_at', $inventory->created_at)
                ->update([
                    'stocks' =>  $request->beg_inv,
                ]);

            if (!$updatedRows) {
                return redirect()->back()->with('error', 'Failed to update item');
            }

            $end_inv = (($request->beg_inv - $request->old_beg_inv) + $totalStockins) - $inventory->stockout;
            $total_amount = $end_inv * $price;

            $update = Inventory::where('code', $request->code)->update(
                [
                    'code' => $request->code,
                    'category' => $request->category,
                    'name' => $request->name,
                    'description' => $request->description,
                    'price' => $request->price,
                    'beg_inv' => $request->beg_inv,
                    'initial' => $initial,
                    'end_inv' =>   $end_inv,
                    'total_amount' =>  $total_amount
                ]
            );


            return redirect()->route('Admins.InventoryHome')->with('success', 'Successfully update item');
        }



        $update = Inventory::where('code', $request->code)->update(
            [
                'code' => $request->code,
                'category' => $request->category,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'beg_inv' => $request->beg_inv,
                'initial' => $initial,
            ]
        );


        if (!$update) {
            return redirect()->back()->with('error', 'Failed to update item');
        }
        return redirect()->route('Admins.InventoryHome')->with('success', 'Successfully update item');
    }
}
