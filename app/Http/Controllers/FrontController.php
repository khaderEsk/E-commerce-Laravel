<?php

namespace App\Http\Controllers;

use App\Mail\ForgetPassword;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductView;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use function Pest\Laravel\json;

class FrontController extends Controller
{
    public function home()
    {
        $featuredProducts = Product::where('isFeatured', 1)->get();
        $first = Product::first();
        $firstCat = Category::where('id', $first->category)->first();
        $weekDeals = Product::latest()->paginate(3);
        $categories = Category::all();
        $hotSeal = Product::where('oldPrice', "!=", null)->get();
        $productView = DB::table('products')->where('userId', Auth::user()->id)
            ->join('product_views', 'products.id', '=', 'product_views.productId')
            ->select('products.*')
            ->latest()->paginate(8);
        // return $productView;
        return view('Front.index', compact('featuredProducts', 'first', 'firstCat', 'weekDeals', 'categories', 'hotSeal', 'productView'));
    }

    public function products_by_category($id)
    {
        $products = Product::where('category', $id)->latest()->paginate(10);
        $categories = Category::all();
        $selectCate = Category::findOrFail($id);
        return view('Front.products_by_category', compact('products', 'categories', 'selectCate'));
    }
    public function product_view($id)
    {
        $product = Product::findOrFail($id);
        $category = Category::where('id', $product->category)->first();

        $user = Auth::user()->id;
        if (!ProductView::where([['userId', $user], ['productId', $id]])->first()) {

            $productView = ProductView::create([
                'userId' => $user,
                'productId' => $id,
                'created_at' => Carbon::now(),
            ]);
        }
        return view('Front.products.view', compact('product', 'category'));
    }

    public function super_deals()
    {
        $categories = Category::all();
        $products = Product::where('oldPrice', '!=', null)->latest()->paginate(8);
        $productView = DB::table('products')->where('userId', Auth::user()->id)
            ->join('product_views', 'products.id', '=', 'product_views.productId')
            ->select('products.*')
            ->latest()->paginate(8);
        return view('Front.superDeals', compact('categories', 'productView', 'products'));
    }

    public function products()
    {
        $categories = Category::all();
        $products = Product::latest()->paginate(8);
        $productView = DB::table('products')->where('userId', Auth::user()->id)
            ->join('product_views', 'products.id', '=', 'product_views.productId')
            ->select('products.*')
            ->latest()->paginate(8);
        return view('Front.productsAll', compact('categories', 'productView', 'products'));
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

    public function search_products(Request $request)
    {
        $products = Product::where('name', 'LIKE', '%' . $request->inputSearch . '%')->get();
        return response()->json(['data' => $products]);
    }
    public function user_logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('home');
    }
}
