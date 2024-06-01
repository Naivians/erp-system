<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Waste;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;

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
            'end_inv' => $endInv ,
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
            $res1 = DB::table('stockins')->where('code', $code)->delete();
            $res2 = DB::table('inventories')->where('code', $code)->delete();
            $res3 = DB::table('stockouts')->where('code', $code)->delete();

            if ($res1 === 0 && $res2 === 1 && $res3 === 0) {
                DB::commit();

                return response()->json([
                    'status' => 200,
                    'message' => 'Successfully move items to waste',
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
                    'message' => 'Successfully move items to waste',
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






        // success

    }
}
