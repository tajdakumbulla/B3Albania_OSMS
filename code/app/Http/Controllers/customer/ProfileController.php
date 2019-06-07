<?php

namespace App\Http\Controllers\customer;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Mail\UserUpdated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\User;
use Yajra\DataTables\Facades\DataTables;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('customer');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('customer.profile')->with('user', Auth::user());
    }

    public function show_orders(){
        return view('customer.orders');
    }

    public function remove_order($order_id){
        $order = Order::find($order_id);
        if($order->status_code == 1) {
            $order->status_code = 6;
            $order->save();
            return response()->json(['data' => $order], 201);
        } else return response()->json(['data' => $order], 203);
    }


    public function order_datatable(){
        $orders = DB::table('orders')->join('status', 'orders.status_code', 'status.id')
            ->where('orders.user_id', Auth::user()->id)
            ->select('orders.*', 'status.title')->get();
        return DataTables::of($orders)
            ->addColumn('action', function ($order) {
                return '
                <a href="' . route('customer.order.show', ['id'=>$order->id]) . '"><i class="material-icons">pageview</i></a>
                ';
            })
            ->make();
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $user = User::findOrFail($id);
        $rules = [
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6|confirmed',
        ];

        $this->validate($request, $rules);

        if($request->has('email') && $user->email != $request->email){
            $user->verified = User::UNVERIFIED;
            $user->verification_token = User::generate_verification_code();
            $user->email = $request->email;
            Mail::to($user->email)->send(new UserUpdated($user));
        }
//        dd($request->all());
        if($request->has('full_name')) $user->full_name = $request->full_name;
        if($request->has('phone')) $user->phone = $request->phone;
        if($request->has('lng')) $user->lng = $request->lng;
        if($request->has('lat')) $user->lat = $request->lat;
        if($request->has('postal_code')) $user->postal_code = $request->postal_code;
        if($request->has('password')) $user->password = bcrypt($request->password);
        if($request->has('user_level')) $user->user_level = $request->user_level;

        if($request->hasFile('image')){

            $user->image = $request->image->store('', 'profile');
        }
        $user->save();
        return view('home');
    }
}
