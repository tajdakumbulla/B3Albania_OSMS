<?php

namespace App\Http\Controllers\admin;

use App\CategoryType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class CategoryTypeController extends Controller
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
        //
    }

    public function datatable(){
        $category_types = CategoryType::all();
        return DataTables::of($category_types)
            ->addColumn('action', function ($category_types) {
                return '<a class="update-type-modal waves-effect waves-light modal-trigger" href="#update-category-type" type-id="'.$category_types->id.'"><i class="material-icons">edit</i></a>';
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
            'type' => 'required|string',
        ];
        $this->validate($request, $rules);
        $data = $request->all();
        $category = CategoryType::create($data);
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
        $category_type = CategoryType::findOrFail($id);
        return response()->json(['data' => $category_type], 201);
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
        $category_type = CategoryType::findOrFail($id);
        $rules = [
            'type' => 'required|string',
        ];
        $this->validate($request, $rules);
        $category_type->type = $request->type;
        $category_type->save();
        return response()->json(['data' => $category_type], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category_type = CategoryType::findOrFail($id);
        if($category_type->delete()) return response()->json(['data' => $category_type], 201);
        else return response()->json(['data' => $category_type], 500);
    }
}
