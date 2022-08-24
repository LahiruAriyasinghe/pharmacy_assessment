<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Http\Request;
use App\Models\UserPrescription;
use App\Models\Product;
use App\Models\Attachment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use DataTables;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function viewQuotation($id)
    {
        $quotation = Quotation::where('id',$id)->get();
        return view('viewquotation')
        ->with('quotation', $quotation);
    }

    public function acceptQuotation(Request $request)
    {

        // dd($request->id);
        if ($request->ajax()) {

            $results = Quotation::where('id', $request->id)
                ->update([
                    'user_approved' => $request->accept
                    ]);
        }

        return [
            'success' => true,
            // 'next' => route('invoice'),
            'msg' => 'Quotation Status Changed successfully',
        ];

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

        $validator = Validator::make($request->all(), [
            'name' => 'required|array|min:1',
        ]);        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $quotationPharmacy = new Quotation;
        $quotationPharmacy->prescription_id = $request->prescription_id;
        $quotationPharmacy->data = json_encode($request->name);
        $quotationPharmacy->total = $request->product_total;
        $quotationPharmacy->save();
        return [
            'success' => true,
            // 'next' => route('invoice'),
            'msg' => 'Quotation Stored successful',
        ];

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function show(Quotation $quotation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function edit(Quotation $quotation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quotation $quotation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quotation $quotation)
    {
        //
    }
}
