<?php

namespace App\Http\Controllers;

use App\Models\UserPrescription;
use App\Models\Quotation;
use App\Models\Product;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use DataTables;

class UserPrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('createprescription');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function editPrescription($id)
    {
        $attachments = Attachment::where('prescription_id',$id)->get();
        $products = Product::all();
        return view('createquotation')
        ->with('products', $products)
        ->with('attachments', $attachments);
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

    

    public function displayImage($filename)
    {
        $path = storage_path('app/'. $filename); 
        if (!File::exists($path)) { 
            abort(404); 
        } 
        $file = File::get($path); 
        $type = File::mimeType($path); 
        $response = Response::make($file, 200); 
        $response->header("Content-Type", $type); 
        return $response; 

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
    

    public function getUserList(Request $request)
    {

        if ($request->ajax()) {

            $data1 = UserPrescription::where('user_id', Auth::id())->with(['user','quotation'])->get();
            // dd($data1);         
            return Datatables::of($data1)
                        ->addIndexColumn()
                          ->editColumn('user', function($task)
                          {
                             return $task->user->name;
                          })
                          ->addColumn('action', function($row){
                                    // $btn = '<a href='.route('edit_prescription', $row->id).' class="edit btn btn-info btn-sm">quote</a>';
                                    $btn = null;
                                    if($row->quotation != null){
                                        $btn = '<a href='.route('view_prescription', $row->quotation->id).' class="edit btn btn-info btn-sm">View Quotation</a>';
                                    }else{
                                        $btn = '<a href="" class="edit btn btn-danger btn-sm">Delete</a>';
 
                                    }
                
                                    return $btn;
                            })
                            ->addColumn('quotaion', function($row){
                                // $btn = '<a href='.route('edit_prescription', $row->id).' class="edit btn btn-info btn-sm">quote</a>';
                                if($row->quotation != null){
                                    if($row->quotation->user_approved == 0){
                                        return "Pending";
                                    }else if($row->quotation->user_approved == 1){
                                        return "Accepted";
                                    }else if($row->quotation->user_approved == 2){
                                        return "Rejected";
                                    }                                   
                                                                
                                }else{
                                    return "Quotation will prepare soon";
                                }
                        })
                            ->rawColumns(['action'])
                          ->make(true);


            // $data = TimeAllocated::latest()->get();
            // return Datatables::of($data)
            //     ->addIndexColumn()
            //     ->make(true);
        }

    }

    public function getList(Request $request)
    {

        if ($request->ajax()) {

            $data1 = UserPrescription::with('user')->get();
            // dd($data1);         
            return Datatables::of($data1)
                        ->addIndexColumn()
                          ->editColumn('user', function($task)
                          {
                             return $task->user->name;
                          })
                          ->addColumn('action', function($row){
                            $btn = null;
                                if($row->quotation == null){
                                        $btn = '<a href='.route('edit_prescription', $row->id).' class="edit btn btn-info btn-sm">quote</a>';
                                        // $btn = $btn.'<a href="javascript:void(0)" class="edit btn btn-danger btn-sm">Delete</a>';
                                }else{
                                    $btn = '<a href='.route('view_prescription', $row->quotation->id).' class="edit btn btn-info btn-sm">View Quotation</a>';
                                }
                                return $btn;
                            })
                            ->addColumn('quotaion', function($row){
                                // $btn = '<a href='.route('edit_prescription', $row->id).' class="edit btn btn-info btn-sm">quote</a>';
                                if($row->quotation != null){
                                    if($row->quotation->user_approved == 0){
                                        return "Pending";
                                    }else if($row->quotation->user_approved == 1){
                                        return "Accepted";
                                    }else if($row->quotation->user_approved == 2){
                                        return "Rejected";
                                    }                                   
                                                                
                                }else{
                                    return "New Prescription";
                                }
                        })
                            ->rawColumns(['action'])
                          ->make(true);


            // $data = TimeAllocated::latest()->get();
            // return Datatables::of($data)
            //     ->addIndexColumn()
            //     ->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeQuotation(Request $request)
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'note' => 'required',
            'image1' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $archive = new UserPrescription;
        $archive->note = $request->note;
        $archive->address = $request->address;
        $archive->time = $request->time;
        $archive->user_id = Auth::id();
        $archive->created_at = Carbon::now()->toDateString();
        $archive->save();

        if ($request->hasFile('image1')) {
            $file = $request->file('image1');
         
            $imageName = time().'.'.$file->extension();  
            $file->move(public_path('images'), $imageName);

            $attachment = new Attachment;
            $attachment->prescription_id = $request->archivetype;
            $attachment->name = $file->getClientOriginalName();
            $attachment->url = $imageName;
            $archive->attachments()->save($attachment);
        
        }

        if ($request->hasFile('image2')) {
            $file = $request->file('image2');
        
            $imageName = time().'.'.$file->extension();  
            $file->move(public_path('images'), $imageName);

            $attachment = new Attachment;
            $attachment->prescription_id = $request->archivetype;
            $attachment->name = $file->getClientOriginalName();
            $attachment->url = $imageName;
            $archive->attachments()->save($attachment);
        }

        if ($request->hasFile('image3')) {
            $file = $request->file('image3');
        
            $imageName = time().'.'.$file->extension();  
            $file->move(public_path('images'), $imageName);

            $attachment = new Attachment;
            $attachment->prescription_id = $request->archivetype;
            $attachment->name = $file->getClientOriginalName();
            $attachment->url = $imageName;
            $archive->attachments()->save($attachment);
        
        }

        if ($request->hasFile('image4')) {
            $file = $request->file('image4');
        
            $imageName = time().'.'.$file->extension();  
            $file->move(public_path('images'), $imageName);

            $attachment = new Attachment;
            $attachment->prescription_id = $request->archivetype;
            $attachment->name = $file->getClientOriginalName();
            $attachment->url = $imageName;
            $archive->attachments()->save($attachment);
        
        }

        if ($request->hasFile('image5')) {
            $file = $request->file('image5');
        
            $imageName = time().'.'.$file->extension();  
            $file->move(public_path('images'), $imageName);

            $attachment = new Attachment;
            $attachment->prescription_id = $request->archivetype;
            $attachment->name = $file->getClientOriginalName();
            $attachment->url = $imageName;
            $archive->attachments()->save($attachment);
        
        }
        return response()->json(['success'=> true, 'msg'=>'Record is successfully added', 'url'=> '/home']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserPrescription  $userPrescription
     * @return \Illuminate\Http\Response
     */
    public function show(UserPrescription $userPrescription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserPrescription  $userPrescription
     * @return \Illuminate\Http\Response
     */
    public function edit(UserPrescription $userPrescription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserPrescription  $userPrescription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserPrescription $userPrescription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserPrescription  $userPrescription
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserPrescription $userPrescription)
    {
        //
    }
}
