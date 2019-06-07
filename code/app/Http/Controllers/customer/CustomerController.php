<?php

namespace App\Http\Controllers\customer;

use App\Cart;
use App\Category;
use App\Favorite;
use App\Order;
use App\OrderProduct;
use App\Product;
use App\Review;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\ProductImage;
use App\ProductCategory;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpKernel\Profiler\Profile;

class CustomerController extends Controller
{

    public function __construct()
    {
        $this->middleware('customer');
    }

    public function verify($token) {
        $user = User::where('verification_token', $token)->firstOrFail();
        $user->verified = 1;
        $user->verification_token = null;
        $user->save();
        return view('home');
    }
    public function index(Request $request) {
        $products = Product::with('images')->where('in_stock', '>', 0)->get();
        $categories = DB::table('categories')
            ->join('category_types', 'categories.category_type_id','=', 'category_types.id')
            ->orderBy('category_type_id')
            ->select('categories.*', 'category_types.type')
            ->get();
        $search = '';
        if($request->has('search') && $request->search != null){
            $search = $request->search;
            $products = $products->filter(function ($product, $key) use ($search) {
                if (strpos($product->title, $search) !== false) return true;
                if (strpos($product->description, $search) !== false) return true;
                if (strpos($product->code, $search) !== false) return true;
                if (strpos($product->barcode, $search) !== false) return true;
                return false;
            });
        }
        if($request->has('categories_selected')) {
            $categories_selected = $request->categories_selected;
            $products = $products->filter(function ($product, $key) use ($categories_selected) {
                $product_categories = DB::table('product_categories')
                    ->join('categories', 'product_categories.category_id', 'categories.id')
                    ->where('product_categories.product_id', $product->id)
                    ->select('categories.id')->pluck('categories.id')->toArray();
                foreach ($categories_selected as $item) {
                    if(!in_array($item, $product_categories)) return false;
                }
                return true;
            });
        }
        if($request->has('favorites')){
            $favorite_selected = true;
            $favorites = Favorite::where('user_id', Auth::user()->id)->pluck('product_id')->toArray();
            $products = $products->filter(function ($product, $key) use ($favorites) {
                if(in_array($product->id, $favorites)) return true;
                return false;
            });
        } else $favorite_selected = false;
        if($request->has('page')){
            $page = $request->page;
            $pages = ceil($products->count()/6);
            if($pages == 1) $page = 1;
            $products = $products->forPage($page, 6)->all();
        } else {
            $page = 1;
            $pages = ceil($products->count()/6);
            $products = $products->forPage(1, 6)->all();
        }

        $wishlist = Favorite::where('user_id', Auth::user()->id)->pluck('product_id')->toArray();
        $cart_item_num = Cart::where('user_id', Auth::user()->id)->count();
//        dd($cart_item_num);
//        dd($products);
        return view('customer.browse')->with([
            'categories' => $categories,
            'products' => $products,
            'categories_selected' => $request->categories_selected,
            'pages' => $pages,
            'search' => $search,
            'page' => $page,
            'wishlist' => $wishlist,
            'cart_item_num' => $cart_item_num,
            'favorite_selected' => $favorite_selected
        ]);
    }

    public function favorite($user_id, $product_id){
        $favorite = Favorite::where('product_id', $product_id)->where('user_id', $user_id)->get();
        if(!$favorite->isEmpty()) {
            $favorite = $favorite[0];
            DB::table('favorites')->where('product_id', $favorite->product_id)->where('user_id', $favorite->user_id)->delete();
            return response()->json(['data' => 'deleted'], 203);
        } else {
            $favorite = Favorite::create([
                'product_id' => $product_id,
                'user_id' => $user_id
            ]);
            return response()->json(['data' => $favorite], 201);
        }
    }

    public function cart(){
        $products = Product::with('images')->get();
        $cart_item_id = Cart::where('user_id', Auth::user()->id)->pluck('product_id')->toArray();
        $products = $products->filter(function ($product, $key) use ($cart_item_id) {
            if(in_array($product->id, $cart_item_id)) return true;
            return false;
        });
//        dd($products);
        return view('customer.cart')->with([
            'products' => $products
        ]);
    }

    public function cart_order(Request $request){
        if(!Auth::user()->is_verified()) {
            return Redirect::back()->with('msg', 'Not Verified');
        }
        DB::beginTransaction();
        $order = Order::create([
            'user_id' => Auth::user()->id,
            'status_code' => 1,
            'note' => $request->note,
        ]);
        $product_id = $request->product_id;
        $quantity = $request->quantity;
        for($i=0; $i<sizeof($product_id); $i++){
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $product_id[$i],
                'quantity' => $quantity[$i]
            ]);
            $product = Product::find($product_id[$i]);
            $product->in_stock = $product->in_stock - $quantity[$i];
            if($product->in_stock<0) {
                DB::rollBack();
                return Redirect::back()->with('msg', 'Product '.$product->title." is out of stock");
            }
        }
        Cart::where('user_id', Auth::user()->id)->delete();
        DB::commit();
        return $this->show_order($order->id);
    }

    public function show_order($id){
        $order = Order::findOrFail($id);
        $products = DB::table('products')
            ->join('order_products', 'products.id', 'order_products.product_id')
            ->where('order_products.order_id', $order->id)
            ->select('products.*', 'order_products.quantity')->get();
        $status = DB::table('status')->where('id', $order->status_code)->first();
        return view('customer.order')->with(['order' => $order, 'products' => $products, 'status' => $status]);
    }

    public function show_product($id, $page)
    {
        $product = Product::findOrFail($id);
        $product_images = ProductImage::where('product_id', $product->id)->get();
        $product_categories = DB::table('categories')
            ->join('product_categories', 'categories.id', 'product_categories.category_id')
            ->where('product_categories.product_id', $product->id)->get();
//        $product_categories = ProductCategory::where('product_id', $product->id);
        $categories = DB::table('categories')
            ->join('category_types', 'categories.category_type_id','=', 'category_types.id')
            ->orderBy('category_type_id')
            ->select('categories.*', 'category_types.type')
            ->get();
        $reviews = Review::with('user')->where('product_id', $id)->get();
        $pages = ceil($reviews->count()/5);
        $reviews = $reviews->forPage($page, 5);
//        dd($reviews);
        return view('customer.product')->with([
            'product' => $product,
            'categories' => $categories,
            'product_categories'=> $product_categories,
            'product_images' => $product_images,
            'reviews' => $reviews,
            'pages' => $pages,
            'page' => $page
        ]);
    }
    public function add_to_cart($id){
        $exists = Cart::where('user_id', Auth::user()->id)->where('product_id', $id)->get();
//        dd($exists);
        if($exists->isNotEmpty()) return response()->json(['data' => $exists], 203);
        $cart_item = Cart::create([
            'user_id' => Auth::user()->id,
            'product_id' => $id
        ]);
        return response()->json(['data' => $cart_item], 201);
    }
    public function order($id){
        $products = Product::with('images')->find($id);
        $products = collect([$products]);
//        dd($products);
        return view('customer.cart')->with([
            'products' => $products
        ]);
    }
    public function make_review(Request $request){
        $exists = Review::where('user_id', Auth::user()->id)->where('product_id', $request->product_id)->get();
//        dd($exists);
        if($exists->isNotEmpty()) return response()->json(['data' => $exists], 203);
        $review = Review::create([
            'user_id' => Auth::user()->id,
            'product_id' => $request->product_id,
            'description' => $request->description,
            'rating' => $request->rating
        ]);
        return response()->json(['data' => $review], 201);
    }

    public function remove_review($id){
        $review = Review::where('user_id', Auth::user()->id)->where('product_id', $id)->delete();
        return response()->json(['data' => $review], 201);
    }

    public function cart_remove($user_id, $product_id){
        $delete = DB::table('carts')->where('user_id', $user_id)->where('product_id', $product_id)->delete();
        return response()->json(['data' => $delete], 201);
    }
}
