<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    public function data(Request $request)
    {
     
        $query = Supplier::with(['image']);

        if($request->ajax()){
            return DataTables::of($query)
                    ->addIndexColumn()
                    ->editColumn('image.image', function(Supplier $supplier){
                        $image =  $supplier->image ? Storage::url($supplier->image->image) : asset('assets/images/no_image.jpg');
                        return '<img id="image" width="50%" height="50%" src="'. $image  .'" alt="pic" class="rounded-circle img-thumbnail"/>';
                    })
                    ->addColumn('action', function($data){
        
                        return view('pages.supplier.button', compact('data'));
                    })
                    ->rawColumns(['action', 'image.image'])
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
        return view('pages.supplier.index');
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
    public function store(SupplierRequest $request)
    {
        if($request->ajax()){
            
            DB::beginTransaction();
            try {
               
                if($request->file('image')){
                    $file = $request->file('image');
                    $image = upload('supplier', $file, 'supplier');

                    $supplier = Supplier::create($request->validated());
                    $supplier->image()->create(['image' => $image]);

                    DB::commit();
                    return response()->json([
                        'type' => 'success',
                        'message' => 'Supllier added successfully'
                    ]);


                }
                    $supplier = Supplier::create(  $request->validated());

                    DB::commit();
                    return response()->json([
                        'type' => 'success',
                        'message' => 'Supllier added successfully'
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
         if(request()->ajax()){
            return response()->json([
            'type' => 'success',
            'data' => $supplier->load(['image']),
            'message' => 'Get Supplier successfully'
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
    public function update(Supplier $supplier, SupplierRequest $request)
    {
   
        if($request->ajax()){
            DB::beginTransaction();
            try {
  
                if($request->file('image')){
                    if (Storage::disk('public')->exists($supplier->image->image)) {
                        Storage::disk('public')->delete($supplier->image->image);
                    }
                    $file = $request->file('image');
                    $image = upload('supplier', $file, 'supplier');
                    $supplier->image()->updateOrCreate([],['image' => $image]);

                }
                    $supplier->update($request->validated());

                    DB::commit();
                    return response()->json([
                            'type' => 'success',
                            'message' => 'Supplier updated successfully'
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
    public function destroy(Supplier $supplier)
    {
        if(request()->ajax()){
            DB::beginTransaction();
            try {
                if($supplier->image){
                    $supplier->image->where('imageable_id', $supplier->id)->where('imageable_type', 'App\Models\Supplier')->delete();
                }
                $supplier->delete();
                DB::commit();


                return response()->json([
                        'type' => 'success',
                        'message' => 'Supplier deleted successfully'
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
}
