<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OtherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active)
    {
        return view('info')->with(['active' => $active]);
    }

    public function dashboard(){
        $sales = DB::table('orders')->join('order_products', 'orders.id', 'order_products.order_id')
            ->select(DB::raw('count(quantity) as quantity'), DB::raw('DATE(orders.created_at) as date'))
            ->groupBy('date')->orderBy('date', 'desc')->get();
        $orders = DB::table('orders')
            ->select(DB::raw('count(id) as quantity'), DB::raw('DATE(orders.created_at) as date'))
            ->groupBy('date')->orderBy('date', 'desc')->get();
        $users = DB::table('users')
            ->select(DB::raw('count(id) as number'), DB::raw('MONTHNAME(users.created_at) as month'))
            ->groupBy('month')->orderBy('month', 'desc')->get();
//        dd($users);

        return view('admin.dashboard')->with(['sales' => $sales, 'orders' => $orders, 'users' => $users]);
    }
}
