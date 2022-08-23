<?php

namespace App\Http\Controllers;

use App\Doctor;
use App\LabReport;
use App\OtherService;
use App\Product;
use App\ProductStock;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
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
        $hospital = Auth::user()->hospital;
        $doctors = Doctor::where('hospital_id', $hospital->id)->get();
        $labReports = LabReport::where('hospital_id', $hospital->id)->get();
        $otherServices = OtherService::where('hospital_id', $hospital->id)->get();
        $products = Product::where('hospital_id', $hospital->id)->get();
        $productStocks = ProductStock::where('hospital_id', $hospital->id)->get();

        return view('invoices.all')
            ->with('hospital', $hospital)
            ->with('doctors', $doctors)
            ->with('labReports', $labReports)
            ->with('products', $products)
            ->with('productStocks', $productStocks)
            ->with('otherServices', $otherServices);
    }
}
