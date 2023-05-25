<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function data(Request $request)
    {
     
        $categories = Category::query();
        if($request->ajax()){
            return DataTables::of($categories)
                    ->addIndexColumn()
                    ->addColumn('select_all', function ($category) {
                        return '
                            <input type="checkbox" class="checkbox" name="ids[]" value="'. $category->id .'">
                        ';
                    })
                    ->addColumn('action', function($data){
                        return view('pages.category.button', compact('data'));
                    })
                    ->rawColumns(['action', 'select_all'])
                    ->make(true);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.category.index');
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
    public function store(CategoryRequest $request)
    {
        if($request->ajax()){
            $data = $request->validated();
            $data['slug'] = Str::slug($data['category_name']);
            
            Category::create($data);

            return response()->json([
                'type' => 'success',
                'message' => 'Category added successfully'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        if(request()->ajax()){
            return response()->json([
            'type' => 'success',
            'data' => $category,
            'message' => 'Get Category successfully'
        ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {

        if($request->ajax()){
            $data = $request->validated();
            $data['slug'] = Str::slug($data['category_name']);
            
            $category->update($data);
            return response()->json([
                    'type' => 'success',
                    'message' => 'Category updated successfully'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if(request()->ajax()){
            $category->delete();

            return response()->json([
                    'type' => 'success',
                    'message' => 'Category deleted successfully'
            ]);
        }
    }

    public function deleteMultiple(Request $request)
    {
        foreach($request->ids as $id){
            Category::findOrFail($id)->delete();
        }

         return response()->json([
                'type' => 'success',
                'message' => 'Category deleted successfully'
            ]);
    }

}
