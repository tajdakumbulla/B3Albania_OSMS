<?php

namespace App\Http\Controllers\admin;

use App\Order;
use App\Product;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use OpenCage\Geocoder\Geocoder;

class ReportController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = DB::table('status')->get();
        return view('admin.report.index')->with(['status' => $status]);
    }

    public function products(Request $request){
        //dd($request->all());
        $products = Product::where('in_stock', '>=', $request->min_quantity)->where('in_stock', '<=', $request->max_quantity)->get();
        $pdf = PDF::loadView('admin.report.products', ['products'=>$products]);
        return $pdf->download('report.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function orders(Request $request)
    {
        $orders = DB::table('orders')->join('users', 'orders.user_id', 'users.id')->join('status', 'orders.status_code', 'status.id');
        if($request->from_date != null){
            $orders = $orders->where('orders.created_at', '>=', $request->from_date);
        }
        if($request->to_date != null){
            $orders = $orders->where('orders.created_at', '<=', $request->to_date);
        }
        $orders = $orders->select('orders.*', 'users.full_name', 'status.title')->get();;
        if($request->status_code != null){
            $status_code = $request->status_code;
            $orders = $orders->filter(function ($orders, $key) use ($status_code) {
                if($orders->status_code == $status_code) return true;
                return false;
            });
        }
        //dd($orders);
        $pdf = PDF::loadView('admin.report.orders', ['orders'=>$orders]);
        return $pdf->download('report.pdf');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sales(Request $request)
    {
        $products = DB::table('products')->join('order_products', 'products.id', 'order_products.product_id');
        if($request->from_date_sales != null){
            $products = $products->where('order_products.created_at', '>=', $request->from_date_sales);
        }
        if($request->to_date_sales != null){
            $products = $products->where('order_products.created_at', '<=', $request->to_date_sales);
        }
        $products = $products->select(DB::raw("products.*, sum(order_products.quantity) as totalQuantity, sum(order_products.quantity * products.price) as totalSum"))
            ->groupBy('products.id', "products.code", "products.barcode", "products.price", "products.title", "products.description", "products.in_stock", "products.created_at", "products.updated_at")->get();
//        dd($products);
        $pdf = PDF::loadView('admin.report.sales', ['products' => $products]);
        return $pdf->download('report.pdf');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function order($id)
    {
        $order = Order::findOrFail($id);

        $products = DB::table('products')
            ->join('order_products', 'products.id', 'order_products.product_id')
            ->where('order_products.order_id', $order->id)
            ->select('products.*', 'order_products.quantity')->get();
        $user = User::findOrFail($order->user_id);
//        $status = DB::table('status')->get();
        $status = DB::table('status')->where('id', $order->status_code)->first();
        $status = $status->title;
        $geocoder = new Geocoder(env('REVERSE_API_OPENCAGEDATA'));
        $address = $geocoder->geocode($user->lat.",".$user->lng);
        $address = $address['results'][0]['formatted'];
        PDF::setOptions([['enable_javascript' => true, 'javascript_delay' => 13500]]);
        $pdf = PDF::loadView('admin.report.order', ['order' => $order, 'products' => $products, 'user' => $user, 'status' => $status, 'address' => $address]);
        return $pdf->download('report.pdf');
//        return view('admin.report.order')->with(['order' => $order, 'products' => $products, 'user' => $user, 'status' => $status]);
    }

}
