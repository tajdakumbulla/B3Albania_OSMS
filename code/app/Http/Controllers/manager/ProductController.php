<?php

namespace App\Http\Controllers\manager;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use App\ProductImage;
use App\Category;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('manager');
    }
    public function index(){
        return view('manager.product.index');
    }

    public function datatable(){

        $products = Product::all();
        return DataTables::of($products)
            ->addColumn('action', function ($product) {
                return '
                <a href="' . route('manager.products.edit', ['id'=>$product->id]) . '"><i class="material-icons">pageview</i></a>
                ';
            })
            ->addColumn('barcode_js', function ($product) {
                return '
                <svg class="barcode"
                     jsbarcode-format="auto"
                     jsbarcode-value="'.$product->barcode.'"
                     jsbarcode-textmargin="0"
                     jsbarcode-height="20"
                     jsbarcode-fontSize="10">
                </svg>
                ';
            })
            ->rawColumns(['barcode_js', 'action'])->make();
    }

    public function edit($id)
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
        return view('manager.product.update')->with([
            'product' => $product,
            'categories' => $categories,
            'product_categories'=> $product_categories,
            'product_images' => $product_images
        ]);
    }

    public function change_stock($id, $stock){
        $product = Product::findOrFail($id);
        $product->in_stock = $stock;
        $product->save();
        return response()->json(['data' => $product], 201);
    }
}
