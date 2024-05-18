<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

        if(!$res){
            return redirect()->back()->with('error', 'Failed to save category!');
        }

        return redirect()->back()->with('success', 'successfully added category');
    }

    function edit($id)
    {
        try {
            $category = Category::findOrFail($id);
            return view('admin.category', ['category' => $category, 'edited' => true, 'categories' => Category::orderBy('id', 'desc')->get()]);
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
        }else{
            return redirect()->back()->with('error', 'Category field is required!');
        }
    }

    function destroy($id)
    {
        $user = Category::findOrFail($id);
        $user->delete();

        if(!$user){
            return response()->json([
                'status' => 404,
                'message' => 'Failed to delete catagory'
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Successfully deleted account'
        ]);
    }
}
