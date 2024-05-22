<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use Illuminate\Support\Facades\Session;
use Illiminate\Support\Str;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        // Retrieve the search query from the request
        $query = $request->get('query');

        // Dynamically create an instance of the specified model
        $modelClass = "App\Models\\" . $request->model;

        if (!class_exists($modelClass)) {
            return response()->json(['error' => 'Model not found'], 404);
        }

        $modelInstance = app($modelClass);

        // Build and execute the search query
        $results = $modelInstance->where(function ($queryBuilder) use ($query, $modelInstance) {
            // Get all column names of the model's table
            $columns = $modelInstance->getConnection()->getSchemaBuilder()->getColumnListing($modelInstance->getTable());

            // Add a condition to search each column
            foreach ($columns as $column) {
                $queryBuilder->orWhere($column, 'like', '%' . $query . '%');
            }
        })
            ->take(10) // Limit the results to 10
            ->get();

        // Return the search results as a JSON response
        return response()->json($results);
    }


    function codeSearch(Request $request)
    {
        $code = $request->input('query');
        $results = Inventory::where('code', $code)->first();


        if ($results) {
            // Get the session data for 'products', or initialize it as an empty array if it doesn't exist
            $cart = session()->get('products', []);

            // Check if the product code already exists in the session
            if (isset($cart[$code])) {
                // session()->forget('products');
                return response()->json([
                    'status' => 419,
                    'message' => "Product code already exists!"
                ]);
            } else {
                // Product doesn't exist, add it to the cart
                $cart[$code] = [
                    'code' => $results->code,
                    'category' => $results->category,
                    'name' => $results->name,
                    'description' => $results->description,
                    'price' => $results->price,
                    'qty' => 1,
                ];

                session()->put('products', $cart);

                return response()->json([
                    'status' => 200,
                    'product' => $cart // Return the updated cart
                ], 200);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => "Product code not found!"
            ]);
        }
    }

    function refresh()
    {

        if (!Session::has('products')) {
            return response()->json([
                'status' => 404,
                'message' => "No Items listed"
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'product' => Session::get('products') // Return the newly added product
            ]);
        }
    }



    function destroy($itemCode)
    {
        $cart = session()->get('products', []);

        $itemCode = strtolower($itemCode);

        //   return response()->json([
        //     'status' => 500,
        //     'message' => $itemCode
        // ]);

        if (isset($cart[$itemCode])) {
            unset($cart[$itemCode]); // Remove the item from the array
            session()->put('products', $cart); // Update the session with the modified cart
            return response()->json([
                'status' => 200,
                'product' => session()->get('products')
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => "Failed to delete Item"
            ]);
        }
    }
}
