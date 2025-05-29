<?php

namespace App\Http\Controllers;

use App\Mail\ForgetPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class FrontController extends Controller
{
    public function home()
    {

        // $user = new  User;
        // $user->name = "Admin";
        // $user->email = "admin@gmail.com";
        // $user->password = Hash::make('12341234');
        // $user->save();
        // $user->assignRole('admin');
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
            'password' => Hash::make($request->password)
        ]);
        $user->assignRole('user');
        return response()->json(['data' => 1]);
    }

    public function forget_password()
    {
        return view('auth.forgot-password');
    }

    public function reset_password(Request $request)
    {
        if ($request->isMethod('post')) {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                Mail::to($user->email)->send(new  ForgetPassword(route('update.password', ['id' => $user->id])));

                return response()->json(['data' => 1]);
            } else {
                return response()->json(['data' => 0]);
            }
        } else {
            return redirect()->route('home');
        }
    }


    public function update_password($id)
    {
        $user = User::findOrFail($id);
        return view('auth.update_password', compact('user'));
    }

    public function updated_password(Request $request)
    {
        if ($request->isMethod('post')) {
            $user = User::where('id', $request->userId)->update([
                'password' => Hash::make($request->password)
            ]);
            return response()->json(['data' => 1]);
        } else {
            return redirect()->route('home');
        }
    }
    public function error_403()
    {
        if (Auth::check()) {
            if (Auth::user()->hasRole('admin')) {

                return redirect()->route('dashboard');
            } else if (Auth::user()->hasRole('user')) {

                return redirect()->route('home');
            }
        } else {
            return redirect()->route('home');
        }
    }

    public function error_404()
    {
        if (Auth::check()) {
            if (Auth::user()->hasRole('admin')) {

                return redirect()->route('dashboard');
            } else if (Auth::user()->hasRole('user')) {

                return redirect()->route('home');
            }
        } else {
            return redirect()->route('home');
        }
    }

    public function user_logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('home');
    }
}
