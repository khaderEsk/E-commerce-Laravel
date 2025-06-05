<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
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


    public function add_product()
    {
        $category = Category::all();
        return view('backend.Products.add', compact('category'));
    }

    public function add_product_store(Request $request)
    {
        if (!$request->hasFile('img')) {
            return response()->json(['error' => 'No image uploaded'], 400);
        }

        $img = $request->file('img');

        if (!$img->isValid()) {
            return response()->json(['error' => 'Invalid image uploaded'], 400);
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $ext = strtolower($img->getClientOriginalExtension());

        if (!in_array($ext, $allowedExtensions)) {
            return response()->json(['error' => 'Unsupported image format'], 400);
        }

        $gen = hexdec(uniqid());
        $imgName = $gen . '.' . $ext;
        $location = public_path('products');

        if (!file_exists($location)) {
            mkdir($location, 0775, true);
        }

        $img->move($location, $imgName);

        $product = Product::create([
            'category' => strip_tags($request->category),
            'name' => strip_tags($request->productName),
            'oldPrice' => strip_tags($request->oldPrice),
            'newPrice' => strip_tags($request->newPrice),
            'img' => $imgName,
            'created_by' => Carbon::now(),
        ]);

        return response()->json(['data' => 1]);
    }



    public function admin_logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('home');
    }
}
