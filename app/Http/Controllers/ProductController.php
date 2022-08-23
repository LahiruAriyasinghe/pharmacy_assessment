<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductType;
use App\ProductStock;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Response;

class ProductController extends Controller
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
        Gate::authorize('view product', Auth::user());
        $hospital = Auth::user()->hospital;
        $product_types = ProductType::where('hospital_id', $hospital->id)->get();
        $products = Product::where('hospital_id', $hospital->id)->get();
        $productstocks = ProductStock::where('hospital_id', $hospital->id)->get();
        
        $referer = $_SERVER['HTTP_REFERER'] ?? null;
        $contains = Str::contains($referer, 'products');
        if($contains){
            $tabName = "product";
        }else{
            $tabName = "stock";
        }

        return view('products.list')
        ->with('products', $products)
        ->with('tabName', $tabName)
        ->with('productstocks',$productstocks)
        ->with('product_types', $product_types);
    }

        /**
     * return all resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function resourcesIndex()
    {
        $hospital = Auth::user()->hospital;
        // $products = ProductStock::where('hospital_id', $hospital->id)->with('product')->get();
        $productstocks = ProductStock::where('hospital_id', $hospital->id)->get();
        return $productstocks;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'name' => 'required|string|max:255',
        ]);
        $hospital = Auth::user()->hospital;
        $product = new Product;
        $product->name = $request->name;
        $product->uom = $request->uom;
        $product->product_type_id = $request->product_type_id;
        $product->hospital_id = $request->user()->hospital->id;
        $product->created_user_id = $request->user()->id;

        $product->save();
        $products = Product::where('hospital_id', $hospital->id)->get();

        $sen['success'] = true;
        $sen['msg'] = 'New product successfully created!';
        $sen['result'] = $products->toArray();
        return Response::json( $sen );

        // return [
        //     'success' => true,
        //     'next' => route('products.index'),
        //     'msg' => 'New product successfully created!',
        // ]->with('product_types', $products);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        // echo json_encode($product);
        Gate::authorize('edit product', Auth::user());
        $hospital = Auth::user()->hospital;
        $product_types = ProductType::where('hospital_id', $hospital->id)->get();
        return view('products.edit')
            ->with('product', $product)
            ->with('product_types', $product_types);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        Gate::authorize('edit product', Auth::user());

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $product->name = $request->name;
        $product->product_type_id = $request->product_type_id;
        $product->uom = $request->uom;
        $product->hospital_id = $request->user()->hospital->id;
        $product->created_user_id = $request->user()->id;
        $product->save();

        return [
            'success' => true,
            'next' => route('products.index'),
            'msg' => $request->name . ' product successfully updated!',
        ];
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        Gate::authorize('delete product', Auth::user());
        DB::table('product_stocks')->where('product_id', $product->id)->delete(); 
        $product->delete();

        $hospital = Auth::user()->hospital;
        $products = Product::where('hospital_id', $hospital->id)->get();

        $sen['success'] = true;
        $sen['msg'] = 'Product successfully deleted!';
        $sen['result'] = $products->toArray();
        return Response::json( $sen );

        // return [
        //     'success' => true,
        //     'next' => route('products.index'),
        //     'msg' => 'Product successfully deleted!',
        // ];
    }
}
