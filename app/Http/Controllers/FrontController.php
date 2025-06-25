<?php

namespace App\Http\Controllers;

use App\Mail\ForgetPassword;
use App\Models\Cart;
use App\Models\Category;
use App\Models\ContactUs;
use App\Models\Favorite;
use App\Models\Order;
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
        $productView = null;
        if (Auth::check()) {
            $productView = DB::table('products')->where('userId', Auth::user()->id)
                ->join('product_views', 'products.id', '=', 'product_views.productId')
                ->select('products.*')
                ->latest()->paginate(8);
        }
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
            User::where('id', $request->userId)->update([
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

    public function search_view(Request $request)
    {
        $products = Product::where('name', 'LIKE', '%' . $request->inputSearch . '%')->latest()->paginate(10);
        $categories = Category::all();
        $productView = DB::table('products')->where('userId', Auth::user()->id)
            ->join('product_views', 'products.id', '=', 'product_views.productId')
            ->select('products.*')
            ->latest()->paginate(8);
        return view('Front.result', compact('categories', 'productView', 'products'));
    }

    public function add_cart(Request $request)
    {
        if (Auth::check()) {
            Cart::create([
                'userId' => Auth::user()->id,
                'productId' => $request->productId,
                'quantity' => $request->quantity
            ]);
            return response()->json(['data' => 1]);
        } else {
            return response()->json(['data' => 0]);
        }
    }

    public function view_cart()
    {
        $data = DB::table('products')->where('userId', Auth::user()->id)
            ->join('carts', 'products.id', '=', 'carts.productId')
            ->select(['carts.*', 'products.*'])
            ->get();
        $totalPrice = DB::table('carts')
            ->where('userId', Auth::user()->id)
            ->join('products', 'carts.productId', '=', 'products.id')
            ->sum(DB::raw('carts.quantity * products.newPrice'));
        return view('Front.cart', compact('data', 'totalPrice'));
    }

    public function cart_delete($id)
    {
        $cart = Cart::findOrFail($id);
        return response()->json(['data' => $cart]);
    }

    public function empty_cart()
    {
        Cart::where('userId', Auth::user()->id)->delete();
        return response()->json([
            'data' => 1
        ]);
    }

    public function add_favorite(Request $request)
    {
        if (Auth::check()) {
            $fav =  Favorite::where([
                ['userId', Auth::user()->id],
                ['productId', $request->productId]
            ])->first();
            if (!$fav) {
                Favorite::create([
                    'userId' => Auth::user()->id,
                    'productId' => $request->productId,
                ]);
                return response()->json(['data' => 1]);
            }
        } else {
            return response()->json(['data' => 0]);
        }
    }

    public function view_favorite()
    {
        $data = DB::table('products')->where('userId', Auth::user()->id)
            ->join('favorites', 'products.id', '=', 'favorites.productId')
            ->select(['favorites.*', 'products.*'])
            ->get();
        return view('Front.favorite', compact('data'));
    }

    public function add_favorite_cart(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'You need to login first',
                'reload' => false
            ], 401);
        }

        $productExists = Cart::where([
            ['productId', $request->id],
            ['userId', Auth::id()]
        ])->exists();

        if ($productExists) {
            return response()->json([
                'success' => false,
                'message' => 'The product is already in your cart',
                'reload' => false
            ]);
        }

        Cart::create([
            'userId' => Auth::id(),
            'productId' => $request->id,
            'quantity' => 1
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully',
            'reload' => true
        ]);
    }

    public function favorite_delete($id)
    {
        $favorite = Favorite::where([
            ['productId', $id],
            ['userId', Auth::user()->id]
        ])->first();
        if ($favorite) {
            $favorite->delete();
            return response()->json(['data' => 1]);
        }
        return response()->json(['data' => 0]);
    }

    public function empty_wishlist()
    {
        Favorite::where('userId', Auth::user()->id)->delete();
        return response()->json([
            'data' => 1
        ]);
    }

    public function add_order_wishlist(Request $request)
    {
        $wishlist = Favorite::where([
            ['productId', $request->id],
            ['userId', Auth::user()->id]
        ])->first();
        if ($wishlist) {
            return response()->json(['data' => 0]);
        }
        Favorite::create([
            'userId' => Auth::user()->id,
            'productId' => $request->id
        ]);
        return response()->json(['data' => 1]);
    }

    public function pay_Now()
    {
        $user = Auth::user()->id;
        $cart = Cart::where('userId', $user)->get();
        $price = [];
        $quantity = [];
        $pro = [];
        foreach ($cart as $val) {
            $product = Product::where('id', $val->productId)->first();
            $price[] = $product->newPrice;
            $quantity[] = $val->quantity;
            $pro[] = $val->productId;
        }
        $total = array_sum($price);
        $proQuantity = $quantity;
        $pro = $pro;
        $order = Order::create([
            'userId' => $user,
            'productId' => json_encode($pro),
            'quantity' => json_encode($proQuantity),
            'price' => json_encode($total),
            'created_at' => Carbon::now()
        ]);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://secure.telr.com/gateway/order.json');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'accept: application/json',
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "\n{\n  \"method\": \"create\",\n  \"store\": 31741,\n  \"authkey\": \"s7LxB-bpxh@26NM7\",\n  \"framed\": 1,\n  \"order\": {\n    \"cartid\": \"$order->id\",\n    \"test\": \"1\",\n    \"amount\": \"$order->price\",\n    \"currency\": \"AED\",\n    \"description\": \"My purchase\"\n  },\n  \"return\": {\n    \"authorised\": \"http://localhost:8000/authorised/order/$order->id\",\n    \"declined\": \"http://localhost:8000/declined/order/$order->id\",\n    \"cancelled\": \"http://localhost:8000/cancelled/order/$order->id\"\n  }\n}\n");

        $response = curl_exec($ch);

        curl_close($ch);
        $details = json_decode($response, true);
        return $details;
        $ref = $details['order']['ref'];
        $url = $details['order']['url'];
        $update = Order::where('id', $order->id)->update([
            'ref' => $ref,
        ]);
        return redirect($url);
    }

    public function contact()
    {
        return view('Front.contact');
    }

    public function contact_us_submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'message' => 'required'
        ]);
        $contactUs = ContactUs::create([
            'name' => strip_tags($request->name),
            'email' => strip_tags($request->email),
            'phone' => strip_tags($request->phone),
            'message' => strip_tags($request->message),
            'created_at' => Carbon::now()
        ]);
        if ($contactUs == true) {
            return redirect()->back()->with('msg', 'Your Message Sent Successfully');
        } else {
            return redirect()->back()->with('msg', 'There is wrong plz try again');
        }
    }

    public function my_account()
    {
        $user = Auth::user();
        return view('Front.profile', compact('user'));
    }

    public function my_account_submit(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = $request->password;
        }
        $user->save();
        if ($user == true) {
            return redirect()->back()->with('msg', 'Your info updated Successfully');
        } else {
            return redirect()->back()->with('msg', 'There is wrong plz try again');
        }
    }

    public function user_logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('home');
    }
}
