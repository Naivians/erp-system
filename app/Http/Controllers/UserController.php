<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function index()
    {
        return view('admin.user', ['users' => User::orderBy('id', 'desc')->get()]);
    }

    public function store(Request $request)
    {


        if (empty($request->name) || empty($request->username) || empty($request->password) || empty($request->confirmPass)) {
            return redirect()->back()->with('error', 'all fields required!');
        }

        if ($request->password != $request->confirmPass) {
            return redirect()->back()->with('error', 'Password do not match');
        }

        $res = User::create([
            'name' => $request->name,
            'username' => $request->input('username', ''),
            'role' => $request->role,
            'password' => Hash::make($request->password), // Hash the password before storing
        ]);

        if (!$res) {
            return redirect()->back()->with('error', 'Failed to save record');
        } else {
            return redirect()->back()->with('success', 'Successfully added new account');
        }
    }

    function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Successfully deleted account'
        ]);
    }

    function edit($id)
    {

        $user = User::findOrFail($id);

        if (!$user) {
            return redirect()->back()->with('error', 'Account ID do not exist');
        } else {
            return view('admin.user', ['editUser' => $user, 'edited' => true, 'users' => User::orderBy('id', 'desc')->get()]);
        }
    }

    public function update(Request $request)
    {


        if (empty($request->password)) {
            $res = User::where('id', $request->user_id)->update([
                'name' => $request->name,
                'username' => $request->username,
                'role' => $request->role,
            ]);
            if (!$res) {
                return redirect()->back()->with('error', 'Failed to save record');
            } else {
                return redirect()->route('Admins.user')->with('success', 'User information updated successfully.');
            }
        } else {
            $res = User::where('id', $request->user_id)->update([
                'name' => $request->name,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            if (!$res) {
                return redirect()->back()->with('error', 'Failed to save record');
            } else {
                return redirect()->route('Admins.user')->with('success', 'User information updated successfully.');
            }
        }



    }
}
