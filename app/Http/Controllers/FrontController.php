<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FrontController extends Controller
{
    public function home()
    {
        // $user = new  User;
        // $user->name = "user";
        // $user->email = "user@gmail.com";
        // $user->password = Hash::make('12341234');
        // $user->save();
        // $user->assignRole('user');
        return view('Front.index');
    }

    public function login_user(Request $request)
    {

        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
            if (Auth::user()->hasRole('admin')) {
                return response()->json(['data' => 1]);
            } else {
                return response()->json(['data' => 2]);
            }
        } else {
            return response()->json(['data' => 0]);
        }
    }

    public function create_account(Request $request)
    {
        if (User::where('email', $request->email)->first()) {
            return response()->json(['data' => 0]);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);
        $user->assignRole('user');
        return response()->json(['data' => 1]);
    }
}
