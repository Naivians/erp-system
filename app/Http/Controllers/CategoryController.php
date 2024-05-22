<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    function index()
    {
        $category = Category::paginate(5);
        return view('admin.category', ['categories' => $category]);
    }

    function store(Request $request)
    {
        // $request->validate([
        //     'category' => 'required'
        // ]);

        if (empty($request->category)) {
            return redirect()->back()->with('error', 'Category field required!');
        }

        $res = Category::create([
            'category' => $request->category
        ]);

        if (!$res) {
            return redirect()->back()->with('error', 'Failed to save category!');
        }

        return redirect()->back()->with('success', 'successfully added category');
    }

    function edit($id)
    {
        try {
            $category = Category::findOrFail($id);
            return view('admin.category', ['category' => $category, 'edited' => true, 'categories' => Category::paginate(5)]);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Category ID does not exist');
        }
    }

    public function update(Request $request)
    {

        if (!empty($request->category)) {
            $res = Category::where('id', $request->category_id)->update([
                'category' => $request->category,
            ]);
            if (!$res) {
                return redirect()->back()->with('error', 'Failed to save record');
            } else {
                return redirect()->route('Admin.category')->with('success', 'Successfully update category.');
            }
        } else {
            return redirect()->back()->with('error', 'Category field is required!');
        }
    }

    public function destroy($category)
    {
        DB::beginTransaction();

        try {
            $res1 = DB::table('categories')->where('category', $category)->delete();
            $res2 = DB::table('inventories')->where('category', $category)->delete();
            $res2 = DB::table('stockins')->where('category', $category)->delete();
            // $res2 = DB::table('stockout')->where('category', $category)->delete();

            if ($res1 === 0 && $res2 === 0) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Failed to delete category');
            }

            DB::commit();
            return redirect()->route('Admin.category')->with('success', 'Successfully deleted category');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
