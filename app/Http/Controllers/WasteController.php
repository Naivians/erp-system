<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Waste;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WasteController extends Controller
{
    function index()
    {

        $wastes = Waste::paginate(10);
        return view('admin.waste', ['wastes' => $wastes]);
    }

    function store($code)
    {
        $results = Inventory::where('code', $code)->first();

        $endInv = $results->stockin - $results->stockout;

        $res = Waste::create([
            'code' => strtoupper($results->code),
            'category' => $results->category,
            'name' => $results->name,
            'description' => $results->description,
            'price' => $results->price,
            'beg_inv' => $results->beg_inv,
            'initial' => $results->initial,
            'stockin' => $results->stockin,
            'stockout' => $results->stockout,
            'end_inv' => $endInv,
            'total_amount' => $endInv * $results->price,
        ]);

        if (!$res) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to store waste',
            ]);
        }


        DB::beginTransaction();

        try {
            $currentYear = Carbon::now()->year;
            $currentMonth = Carbon::now()->month;

            // Delete records from the Stockin model
            $res = Inventory::where('code', $code)
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)
                ->delete();

            if (!$res == 1) {
                DB::commit();

                return response()->json([
                    'status' => 200,
                    'message' => 'Successfully move items to waste',
                    'url' => route('Admins.InventoryHome'),
                ]);
            }
        } catch (\Exception $e) {

            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => 'Failed to delete item',
            ]);
        }






        // success

    }
}
