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

class CashierReportsController extends Controller
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

        $cashInHand = DB::table('transactions')
            ->where('created_user_id', Auth::id())
            ->whereDate('created_at', Carbon::now())
            ->sum(DB::raw('credit - debit'));

        return view('reports.cashier.list', [
            'cashInHand' => $cashInHand,
        ]);
    }

    /**
     * return all resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function resourcesIndex()
    {
        $transactions = Transaction::with('invoiceName')->where('created_user_id', Auth::id())
            ->whereDate('created_at', Carbon::today())
            ->get();

        return new TransactionCollection($transactions);
    }

}
