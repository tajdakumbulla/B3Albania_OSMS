<?php

namespace App\Http\Controllers\admin;
use App\Category;
use App\ProductImage;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
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
        $product = Product::all();
        return view('admin.product.index')->with(['products'=>$product]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        return view('admin.product.create');
    }

    public function datatable(){
        $products = Product::all();
        return DataTables::of($products)
            ->addColumn('action', function ($product) {
                return '
                <a href="' . route('products.edit', ['id'=>$product->id]) . '"><i class="material-icons">edit</i></a>
                <a href="' . route('products.show', ['id'=>$product->id]) . '"><i class="material-icons">pageview</i></a>
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'code' => 'unique:products',
            'barcode' => 'required|unique:products',
            'price' => 'required|numeric',
            'title' => 'required|string',
            'description' => 'required|string',
            'in_stock' => 'required|integer'
        ];
        $this->validate($request, $rules);
        $data = $request->all();
        $product = Product::create($data);

        if($request->hasFile('product_image')){
            Product::create([
                'product_id' => $product->id,
                'url' => $request->profile_image->store('profile'),
            ]);
        }
        $categories = DB::table('categories')
            ->join('category_types', 'categories.category_type_id','=', 'category_types.id')
            ->orderBy('category_type_id')
            ->select('categories.*', 'category_types.type')
            ->get();
        return view('admin.product.update')->with(['product' => $product, 'categories' => $categories]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        return view('admin.product.show')->with([
            'product' => $product,
            'categories' => $categories,
            'product_categories'=> $product_categories,
            'product_images' => $product_images
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        return view('admin.product.update')->with([
            'product' => $product,
            'categories' => $categories,
            'product_categories'=> $product_categories,
            'product_images' => $product_images
        ]);
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
        $product = Product::findOrFail($id);
        $rules = [
            'price' => 'numeric',
            'title' => 'string',
            'description' => 'string',
            'in_stock' => 'integer'
        ];
        $this->validate($request, $rules);
        if($request->has('code')) $product->code = $request->code;
        if($request->has('barcode')) $product->barcode = $request->barcode;
        if($request->has('price')) $product->price = $request->price;
        if($request->has('title')) $product->title = $request->title;
        if($request->has('description')) $product->description = $request->description;
        if($request->has('in_stock')) $product->in_stock = $request->in_stock;
        $product->save();
        return $this->show($product->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function add_category($product_id, $category_id)
    {
        $product_category = ProductCategory::create([
            'product_id' => $product_id,
            'category_id' => $category_id
        ]);
        $category = Category::findOrFail($product_category->category_id);
        return response()->json(['data' => $category], 201);
    }

    public function remove_category($product_id, $category_id)
    {
        $product_category = ProductCategory::where('product_id', $product_id)->where('category_id', $category_id);
        $product_category->delete();
        return response()->json(['data' => $product_category], 201);
    }

    public function add_image($id, Request $request){
        if($request->hasFile('image')){
            $url = $request->image->store('', 'image');
            $product_image = ProductImage::create([
                'product_id' => $id,
                'url' => $url
            ]);
        }
        return response()->json([
            'data' => $product_image,
            'asset' => asset('/img/'.$url)
        ], 201);
    }

    public function remove_image($id, $url){
        $product_image = ProductImage::where('url', $url);
        $product_image->delete();
        return response()->json(['data' => $product_image], 201);
    }
}
