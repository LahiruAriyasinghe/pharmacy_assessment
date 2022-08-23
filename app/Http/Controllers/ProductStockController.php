<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductType;
use App\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Response;

class ProductStockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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

    public function resourcesProductIndex()
    {
        $hospital = Auth::user()->hospital;
        $products = Product::where('hospital_id', $hospital->id)->get();
        return $products;
    }

    public function resourcesStockIndex()
    {
        $hospital = Auth::user()->hospital;
        $products = ProductStock::where('hospital_id', $hospital->id)->with('product')->get();
        return $products;
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
        Gate::authorize('create product', Auth::user());

        $request->validate([
            'batch_no' => 'required|unique:product_stocks,batch_no,NULL,NULL,deleted_at,NULL|string|max:255',
            'sell_price' => 'required|between:0,99999999.99',
        ]);

        $stock = new ProductStock;
        
        $stock->product_id = $request->product_id;
        $stock->batch_no = $request->batch_no;
        $stock->sell_price = $request->sell_price;
        $stock->hospital_id = $request->user()->hospital->id;
        $stock->created_user_id = $request->user()->id;
        $stock->save();

        $hospital = Auth::user()->hospital;
        $productstocks = ProductStock::where('hospital_id', $hospital->id)->get();

        $sen['success'] = true;
        $sen['msg'] = 'New stock successfully created!';
        $sen['result'] = $productstocks->toArray();
        return Response::json( $sen );

        // return [
        //     'success' => true,
        //     'next' => route('products.index'),
        //     'msg' => 'New stock successfully created!',
        // ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductStock  $productStock
     * @return \Illuminate\Http\Response
     */
    public function show(ProductStock $productStock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductStock  $productStock
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductStock $stock)
    {
        
        Gate::authorize('edit product', Auth::user());
        $hospital = Auth::user()->hospital;
        $product_types = ProductType::where('hospital_id', $hospital->id)->get();
        $products = Product::where('hospital_id', $hospital->id)->get();
        $productstocks = ProductStock::where('hospital_id', $hospital->id)->get();
     
        return view('stocks.edit')
            ->with('productStock', $stock)
            ->with('products', $products)
            ->with('productstocks',$productstocks)
            ->with('product_types', $product_types);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductStock  $productStock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductStock $stock)
    {
        Gate::authorize('edit product', Auth::user());
        // echo json_encode();
        $request->validate([
            //  'batch_no' => 'required|string|max:255|unique:product_stocks,batch_no,NULL,NULL,deleted_at,NULL',
            'batch_no' => 'required|string|max:255',
        
        ]);

        $stock->product_id = $request->product_id;
        $stock->batch_no = $request->batch_no;
        $stock->sell_price = $request->sell_price;
        $stock->hospital_id = $request->user()->hospital->id;
        $stock->created_user_id = $request->user()->id;
        $stock->save();

        return [
            'success' => true,
            'next' => route('products.index'),
            'msg' => 'Stock successfully updated!',
        ];
     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductStock  $productStock
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductStock $stock)
    {
        Gate::authorize('delete product', Auth::user());
        $stock->delete();
        return [
            'success' => true,
            'next' => route('products.index'),
            'msg' => 'Stock successfully deleted!',
        ];
    }


    public function checkStockExist(){

        $hospital = Auth::user()->hospital;
        // $productstocks = ProductStock::where('hospital_id', $hospital->id)->get();
        $batchNumbers = DB::table('product_stocks')->select('batch_no')
                                                    ->whereNull('deleted_at')
                                                    ->get();
        $sen['success'] = true;
        $sen['result'] = $batchNumbers->toArray();
        return Response::json( $sen );

    }
}
