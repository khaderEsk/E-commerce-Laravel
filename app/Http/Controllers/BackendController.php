<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BackendController extends Controller
{
    public function index()
    {
        return view('backend.index');
    }



    public function category()
    {
        $categories = Category::latest()->paginate(10);
        return view('backend.categories.index', compact('categories'));
    }

    public function add_category()
    {
        return view('backend.categories.add');
    }

    public function add_category_store(Request $request)
    {
        if (Category::where('name', $request->name)->first()) {
            return response()->json(['data' => 0]);
        }
        $category = Category::create([
            'name' => $request->name,
            'order' => $request->order,
            'created_by' => Carbon::now(),
        ]);
        return response()->json(['data' => 1]);
    }

    public function category_edit($id)
    {
        $category = Category::findOrFail($id);
        return view('backend.categories.edit', compact('category'));
    }


    public function category_updated(Request $request)
    {
        $category = Category::where('id', $request->id)->update([
            'name' => strip_tags($request->name),
            'order' => strip_tags($request->order),
        ]);
        return response()->json(['data' => 1]);
    }

    public function category_delete(Request $request)
    {
        $category = Category::where('id', $request->id)->delete();
        return response()->json(['data' => 1]);
    }

    public function admin_logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('home');
    }
}
