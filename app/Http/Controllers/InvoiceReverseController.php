<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class InvoiceReverseController extends Controller
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
        Gate::authorize('create invoice', Auth::user());

        $hospital = Auth::user()->hospital;
        $admins = User::permission('reverse invoice')
            ->where('hospital_id', $hospital->id)
            ->get();

        return view('invoices-reverse.all')->with('admins', $admins);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('create invoice', Auth::user());

        $request->validate([
            'invoice_id' => 'required|string|exists:transactions,invoice_id',
            'admin_id' => 'required|exists:users,id',
            'admin_password' => 'nullable|string|max:255',
        ]);

        $createdUser = Auth::user();
        $createdUserHospital = $createdUser->hospital;

        // Auth admin user
        $user = User::where([
            ['id', $request->admin_id],
            ['hospital_id', $createdUserHospital->id],
        ])->firstOrFail();

        if (!Hash::check($request->admin_password, $user->password)) {
            throw ValidationException::withMessages(['admin_password' => 'Given password is incorrect.']);
        }

        // check Admin User has permission
        if (!$user->hasPermissionTo('reverse invoice')) {
            throw ValidationException::withMessages(['admin_password' => 'User does not have permission to reverse invoice']);
        }

        // New Transaction with debit
        $returnedValues = DB::transaction(function () use ($request, $user) {

            // check invoice already reversed
            $reversedTransaction = Transaction::where([
                ['invoice_id', $request->invoice_id],
                ['reversed', 1],
            ])->first();
            if($reversedTransaction){
                throw ValidationException::withMessages(['invoice_id' => 'This invoice has been already reversed.']);
                return;
            }

            // get invoice transaction
            $oldTransaction = Transaction::where([
                ['invoice_id', $request->invoice_id],
                ['reversed', 0],
            ])->whereDate('created_at', Carbon::now())
            ->first();
            $oldInvoice = $oldTransaction ? $oldTransaction->invoice->first() : null;
            if(!$oldInvoice){
                throw ValidationException::withMessages(['invoice_id' => 'This invoice does not exists.']);
                return;
            }

            if($oldTransaction->created_user_id != Auth::id()){
                throw ValidationException::withMessages(['invoice_id' => 'You don\'t have authorized to reverse this invoice.']);
                return;
            }
            
            $oldInvoice->delete();

            // Transaction
            $newTransaction = new Transaction;
            $newTransaction->patient_id = $oldTransaction->patient_id;
            $newTransaction->note = 'reverse transaction - ' . $oldTransaction->id . ' (invoice - ' . $oldTransaction->invoice_id . ') by admin user ' . $user->username;
            $newTransaction->type = $oldTransaction->type;
            $newTransaction->reversed = 1;
            $newTransaction->credit = 0;
            $newTransaction->debit = $oldTransaction->credit;
            $newTransaction->invoice_type = $oldTransaction->invoice_type;
            $newTransaction->invoice_id = $oldTransaction->invoice_id;
            $newTransaction->save();
        });

        return [
            'success' => true,
            'next' => route('home'),
            'msg' => 'Invoice reversed successfully!',
        ];
    }
}
