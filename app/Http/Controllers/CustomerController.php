<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    public function data(Request $request)
    {
     
        $query = Customer::with(['image']);

        if($request->ajax()){
            return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('image.image', function($data){
                        $image =  $data->image ? Storage::url($data->image->image) : asset('assets/images/no_image.jpg');
                        return '<img id="image" width="50%" height="50%" src="'. $image  .'" alt="pic" class="rounded-circle img-thumbnail"/>';
                    })
                    ->addColumn('action', function($data){
        
                        return view('pages.customer.button', compact('data'));
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
        return view('pages.customer.index');
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
    public function store(CustomerRequest $request)
    {
        if($request->ajax()){
            
            DB::beginTransaction();
            try {
               
                if($request->file('image')){
                    $file = $request->file('image');
                    $image = upload('supplier', $file, 'supplier');

                    $customer = Customer::create($request->validated());
                    $customer->image()->create(['image' => $image]);

                    DB::commit();
                    return response()->json([
                        'type' => 'success',
                        'message' => 'Supllier added successfully'
                    ]);


                }
                    $customer = Customer::create(  $request->validated());

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
    public function edit(Customer $customer)
    {
         if(request()->ajax()){
            return response()->json([
            'type' => 'success',
            'data' => $customer->load(['image']),
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
    public function update(Customer $customer, CustomerRequest $request)
    {
        if($request->ajax()){
            DB::beginTransaction();
            try {
  
                if($request->file('image')){
                    if (Storage::disk('public')->exists($customer->image->image)) {
                        Storage::disk('public')->delete($customer->image->image);
                    }
                    $file = $request->file('image');
                    $image = upload('customer', $file, 'customer');
                    $customer->image()->updateOrCreate([],['image' => $image]);

                }
                    $customer->update($request->validated());

                    DB::commit();
                    return response()->json([
                            'type' => 'success',
                            'message' => 'Customer updated successfully'
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
     public function destroy(Customer $customer)
    {
        if(request()->ajax()){
            DB::beginTransaction();
            try {
                
                if($customer->image){
                    $customer->image->where('imageable_id', $customer->id)->where('imageable_type', 'App\Models\Customer')->delete();
                }
                 $customer->delete();

                DB::commit();
                return response()->json([
                        'type' => 'success',
                        'message' => 'Customer deleted successfully'
                ]);
            } catch (Exception $err) {
                DB::rollBack();
                return response()->json([
                        'type' => 'failed',
                        'message' => $err
                ]);
            }
            
        }
    }
}
