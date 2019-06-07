<?php

namespace App\Http\Controllers\admin;

use App\Category;
use App\CategoryType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
class CategoryController extends Controller
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
        $categories = Category::all();
        $category_types = CategoryType::all();
        return view('admin.category.index')->with(['categories'=>$categories, 'category_types'=>$category_types]);
    }

    public function datatable(){
        $categories = DB::table('categories')
            ->join('category_types', 'categories.category_type_id','=', 'category_types.id')->select('categories.*','category_types.type')
            ->get();
        return Datatables::of($categories)
            ->addColumn('action', function ($category) {
                return '<a class="update-modal waves-effect waves-light modal-trigger" href="#update-category" category-id="'.$category->id.'"><i class="material-icons">edit</i></a>';
            })
            ->make();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'title' => 'required|string',
            'description' => 'required|string'
        ];
        $this->validate($request, $rules);
        $data = $request->all();
//        dd($data);
        $category = Category::create($data);
        return response()->json(['data' => $category], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json(['data' => $category], 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $category = Category::findOrFail($id);
        $rules = [
            'title' => 'required|string',
            'description' => 'required|string',
            'category_type_id' => 'required'
        ];
        $this->validate($request, $rules);
        $category->title = $request->title;
        $category->description = $request->description;
        $category->category_type_id = $request->category_type_id;
//        dd($data);
        $category->save();
        $category_type = CategoryType::findOrFail($category->category_type_id);
        return response()->json([
            'data' => $category,
            'category_type' => $category_type->type
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(['data' => $category], 201);
    }
}
