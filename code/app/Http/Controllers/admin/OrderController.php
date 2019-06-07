<?php

namespace App\Http\Controllers\admin;

use App\Order;
use App\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\User;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.order.index');
    }

    public function datatable(){
        $orders = DB::table('orders')->join('users', 'orders.User_id', 'users.id')
            ->join('status', 'orders.status_code', 'status.id')
            ->select('orders.*', 'users.full_name', 'status.title as status')
            ->get();
        return DataTables::of($orders)
            ->addColumn('action', function ($order) {
                return '
                <a href="' . route('orders.show', ['id'=>$order->id]) . '"><i class="material-icons">pageview</i></a>
                ';})
            ->addColumn('action_2', function ($order) {
                return '
                <a href="' . route('orders.report', ['id'=>$order->id]) . '"><i class="material-icons">print</i></a>
                ';})
            ->rawColumns(['action_2', 'action'])
            ->make();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);

        $products = DB::table('products')
            ->join('order_products', 'products.id', 'order_products.product_id')
            ->where('order_products.order_id', $order->id)
            ->select('products.*', 'order_products.quantity')->get();
        $user = User::findOrFail($order->user_id);
        $status = DB::table('status')->get();
        return view('admin.order.show')->with(['order' => $order, 'products' => $products, 'user' => $user, 'status' => $status]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function change_status($id, $status){
        $order = Order::findOrFail($id);
        $order -> status_code = $status;
        $order -> save();
        return response()->json(['data' => $order], 201);
    }
}
