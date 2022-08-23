<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionCollection;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AdminCashierReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the hospitals to login.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('create invoice', Auth::user());

        return view('reports.admin.list');
    }

    /**
     * return all resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function resourcesIndex()
    {
        $transactions = Transaction::with(['invoiceName', 'createdUser:id,username'])
            ->where('hospital_id', Auth::user()->hospital->id)
            // ->whereDate('created_at', Carbon::today())
            ->get();

        return new TransactionCollection($transactions);
    }

}
