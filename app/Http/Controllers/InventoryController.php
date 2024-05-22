<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Stockin;
use App\Models\Inventory;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class InventoryController extends Controller
{
    function index()
    {

        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;


        $results = Stockin::select('code', DB::raw('SUM(stocks) as total_stocks'))
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->groupBy('code')
            ->get();

        // / Use a transaction to ensure atomic updates
        DB::transaction(function () use ($results) {
            // Update the inventory for each code based on the results from the stockin table
            foreach ($results as $res) {
                Inventory::where('code', $res->code)->update(['stockin' => $res->total_stocks]);
            }

            // Get all inventory codes
            $inventoryCodes = Inventory::pluck('code');

            // Set stockin to 0 for inventory items not updated above
            foreach ($inventoryCodes as $code) {
                if (!$results->contains('code', $code)) {
                    Inventory::where('code', $code)->update(['stockin' => 0]);
                }
            }
        });

        // Fetch data for the view
        $inventories = Inventory::paginate(10);
        $categories = Category::all();

        return view('admin.checklist', ['inventories' => $inventories, 'categories' => $categories]);
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

            return redirect()->back()->with('success', 'Successfully added new record!');
        }
    }
    function destroy($code)
    {

        DB::beginTransaction();

        try {
            $res1 = DB::table('stockins')->where('code', $code)->delete();
            $res2 = DB::table('inventories')->where('code', $code)->delete();
            // $res3 = DB::table('stockout')->where('code', $code)->delete();

            if ($res1 === 0 && $res2 === 0) {
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
        } catch (\Exception $e) {
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
