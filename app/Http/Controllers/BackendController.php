<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ContactUs;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class BackendController extends Controller
{
    public function index()
    {
        $category = Category::count('id');
        $product = Product::where('isFeatured', 0)->count('id');
        $productFeatured = Product::where('isFeatured', 1)->count('id');
        $messages = ContactUs::count('id');
        return view('backend.index', compact('category', 'product', 'productFeatured', 'messages'));
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
        $category = Category::create([
            'name' => $request->name,
            'order' => $request->order,
            'created_by' => Carbon::now(),
            'img' => 'categories/' . $imgName,
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
        $category = Category::where('id', $request->id)->first();
        if ($request->hasFile('img')) {
            if ($category->img && file_exists(public_path($category->img))) {
                unlink(public_path($category->img));
            }
            $img = $request->file('img');
            $gen = hexdec(uniqid());
            $ex = strtolower($img->getClientOriginalExtension());
            $name = $gen . '.' . $ex;
            $location = 'categories/';
            $destination = public_path($location);
            $img->move($destination, $name);
            $category->img = $location . $name;
        }

        $category->name = strip_tags($request->name);
        $category->order = strip_tags($request->order);
        $category->save();
        if ($category) {
            return response()->json(['data' => 1]);
        }
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
            'description' => strip_tags($request->description),
            'img' => 'products/' . $imgName,
            'isFeatured' => 0,
            'created_by' => Carbon::now(),
        ]);

        return response()->json(['data' => 1]);
    }

    public function product_view()
    {
        $products = Product::latest()->paginate(10);
        return view('backend.Products.index', compact('products'));
    }

    public function product_edit($id)
    {
        $product = Product::findOrFail($id);
        // $category = Category::all();
        return view('backend.Products.edit', compact('product'));
    }

    public function product_updated(Request $request)
    {
        $product = Product::where('id', $request->id)->first();
        if ($request->hasFile('img')) {
            if ($product->img && file_exists(public_path($product->img))) {
                unlink(public_path($product->img));
            }
            $img = $request->file('img');
            $gen = hexdec(uniqid());
            $ex = strtolower($img->getClientOriginalExtension());
            $name = $gen . '.' . $ex;
            $location = 'products/';
            $destination = public_path($location);
            $img->move($destination, $name);
            $product->img = $location . $name;
        }

        $product->category = $request->category;
        $product->name = strip_tags($request->productName);
        $product->oldPrice = strip_tags($request->oldPrice);
        $product->newPrice = strip_tags($request->newPrice);
        $product->description = strip_tags($request->description);
        $product->save();
        if ($product) {
            return response()->json(['data' => 1]);
        }
    }

    public function product_delete($id)
    {
        $product = Product::where('id', $id)->first();
        unlink(public_path($product->img));
        $product->delete();
        return response()->json(['data' => 1]);
    }

    public function Featured_Products_add()
    {
        $category = Category::all();
        return view('backend.Featured_Products.add', compact('category'));
    }

    public function product_featured_store(Request $request)
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
            'description' => strip_tags($request->description),
            'img' => 'products/' . $imgName,
            'isFeatured' => 1,
            'created_by' => Carbon::now(),
        ]);
        return response()->json(['data' => 1]);
    }

    public function Featured_Products_view()
    {
        $products = Product::where('isFeatured', 1)->latest()->paginate(10);
        return view('backend.Featured_Products.index', compact('products'));
    }

    public function profile()
    {
        return view('backend.profile');
    }

    public function update_profile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return response()->json(['data' => 1]);
    }

    public function contact_us_all()
    {
        $messages = ContactUs::get();
        return view('backend.Contact.index', compact('messages'));
    }

    public function contact_delete($id)
    {
        $contact = ContactUs::findOrFail($id);
        $contact->delete();
        return redirect()->back()->with('msg', 'Your Message Sent Successfully');
    }

    public function users()
    {
        $users = User::role('user')->latest()->paginate(10);
        return view('backend.users.index', compact('users'));
    }

    public function admin_logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }
}
