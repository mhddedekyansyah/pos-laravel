<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Supplier;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class ProductController extends Controller
{
    public function data(Request $request)
    {
        
        $query = Product::with(['image', 'stock']);
        if($request->ajax()){
            return DataTables::of($query)
                    ->addIndexColumn()
                    ->editColumn('stock.stock', function(Product $product){
                        return $product->stock->stock;
                    })
                    ->addColumn('select_all', function ($data) {
                        return '
                            <input type="checkbox" class="checkbox" name="ids[]" value="'. $data->id .'">
                        ';
                    })
                    ->addColumn('action', function($data){
                        return view('pages.product.button', compact('data'));
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
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('pages.product.index', compact('categories', 'suppliers'));
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
    public function store(ProductRequest $request)
    {
        if($request->ajax()){

            DB::beginTransaction();
            try {
                
                $data = $request->validated();
             
                $data['slug'] = $data['product_name'];
                $image = upload('product', $request->file('image'), 'product');
                $product = Product::create($data);
                Stock::create(['product_id' => $product->id, 'stock' => 0]);
                
                $product->image()->create(['image' => $image]);

                DB::commit();
                return response()->json([
                        'type' => 'success',
                        'message' => 'Product added successfully'
                ]);
              
                } catch (Exception $err) {
                    DB::rollback();
                    return response()->json([
                    'type' => 'error',
                    'message' => $err
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        if(request()->ajax()){
            return response()->json([
            'type' => 'success',
            'data' => $product->load(['category', 'supplier', 'image', 'stock']),
            'message' => 'Get Product successfully'
        ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        if(request()->ajax()){
            return response()->json([
            'type' => 'success',
            'data' => $product->load('image', 'supplier', 'category'),
            'message' => 'Get Product successfully'
        ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Product $product, ProductUpdateRequest $request)
    {

        if($request->ajax()){
            DB::beginTransaction();
            try {
  
                if($request->has('image')){
                    if (Storage::disk('public')->exists($product->image->image)) {
                        Storage::disk('public')->delete($product->image->image);
                    }
                    $file = $request->file('image');
                    $image = upload('product', $file, 'product');
                    $product->image()->updateOrCreate([],['image' => $image]);
                }
                    $product->update($request->validated());

                    DB::commit();
                    return response()->json([
                            'type' => 'success',
                            'message' => 'Product updated successfully'
                    ]);
              
                } catch (Exception $err) {
                    DB::rollBack();
                    return response()->json([
                        'type' => 'error',
                        'message' => $err
            ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if(request()->ajax()){
            DB::beginTransaction();
            try {
                if($product->image){
                    $product->image->where('imageable_id', $product->id)->where('imageable_type', 'App\Models\Product')->delete();
                }
                $product->delete();

                DB::commit();

                return response()->json([
                        'type' => 'success',
                        'message' => 'Product deleted successfully'
                ]);
            } catch (\Exception $err) {
                DB::rollBack();
                return response()->json([
                        'type' => 'error',
                        'message' => $err
                ]);
            }
            
        }
    }

    public function deleteMultiple(Request $request)
    {
        if($request->ajax()){
            DB::beginTransaction();
            try {
                foreach($request->ids as $id){
                    Product::findOrFail($id)->delete();
                    Image::where('imageable_id', $id)->where('imageable_type', 'App\Models\Product')->delete();
                }
                DB::commit();
                return response()->json([
                    'type' => 'success',
                    'message' => 'Product deleted successfully'
                ]);
            } catch (\Exception $err) {
                DB::commit();
                return response()->json([
                    'type' => 'error',
                    'message' => 'Failed deleted successfully'
                ]);
            }
            

         
        }
    }
}
