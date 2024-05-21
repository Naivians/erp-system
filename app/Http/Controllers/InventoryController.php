<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class InventoryController extends Controller
{
    function index(){
        return view('admin.checklist', ['inventories' => Inventory::paginate(10), 'categories' => Category::all()]);
    }

    function store(Request $request){


        if($request->code == null || $request->name == null || $request->description == null || $request->price == null || $request->category == null || $request->beg_inv == null ){
            return redirect()->back()->with('error', 'All fields are required');
        }

        $is_exist = Inventory::where('code', $request->code)->exists();

        // do not accept if exist
        if($is_exist){
            return redirect()->back()->with('error', 'Product code Already exist in the masterlist');
        }else{
            // process data
            $price = (float) $request->price;
            $initial = (float) ($request->beg_inv * $price);

            $res = Inventory::create([
                'code' => $request->code,
                'category' => $request->category,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'beg_inv' => $request->beg_inv,
                'initial' => $initial,
                'remarks' => '',
            ]);

            if(!$res){
                return redirect()->back()->with('error', 'Failed to record data');
            }

            return redirect()->back()->with('success', 'Successfully added new record!');
        }
    }
    function destroy($id)
    {
        $user = Inventory::findOrFail($id);
        $user->delete();

        if(!$user){
            return redirect()->back()->with('error', 'Failed to save record');
        }

        return redirect()->route('Admins.InventoryHome')->with('success', 'Successfully deleted item');
    }


    function edit($id)
    {
        try {
            $inventory = Inventory::findOrFail($id);
            return view('admin.inventory.index', ['item' => $inventory, 'edited' => true, 'inventories' => Inventory::paginate(10), 'categories' => Category::all()]);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Item ID does not exist');
        }
    }

}
