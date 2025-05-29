<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BackendController extends Controller
{
    public function index()
    {
        return view('backend.index');
    }

    public function admin_logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('home');
    }


    public function add_category()
    {
        return view('backend.categories.add');
    }

    public function add_category_post(Request $request)
    {
        // $category = Category::created([
        //     'name' => $request->name,
        //     'order' => $request->order,
        // ]);

        return redirect()->route('categories');
    }
}
