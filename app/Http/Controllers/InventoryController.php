<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;

class InventoryController extends Controller
{
    function index(){
        return view('admin.inventory.index', ['inventories' => Inventory::paginate(10)]);
    }
}
