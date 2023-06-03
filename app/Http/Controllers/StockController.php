<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockRequest;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StockController extends Controller
{
    public function data(Request $request)
    {
     
        $query = Stock::with(['product']);
        if($request->ajax()){
            return DataTables::of($query)
                    ->addIndexColumn()
                    ->editColumn('product.product_name', function(Stock $stock){
                        return $stock->product->product_name;
                    })
                    ->addColumn('action', function($data){
                        return view('pages.stock.button', compact('data'));
                    })
                    ->rawColumns(['action'])
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
        $products = Product::all();
        return \view('pages.stock.index', \compact('products'));
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
    public function store(StockRequest $request)
    {
        if($request->ajax()){
            $stock = Stock::where('product_id', $request->product_id)->first();
            if($stock){
                $stock->update(['stock' => $stock->stock + $request->stock]);
            }else{
                Stock::create($request->validated());
            }

            return response()->json([
                'type' => 'success',
                'message' => 'Stock added successfully'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        if(request()->ajax()){
            return response()->json([
                'type' => 'success',
                'data' => $stock->load('product'),
                'message' => 'Get Category successfully'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock $stock)
    {
        if($request->ajax()){
          
            $stock->update($request->all());
            
            return response()->json([
                'type' => 'success',
                'message' => 'Stock updated successfully'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        //
    }
}
