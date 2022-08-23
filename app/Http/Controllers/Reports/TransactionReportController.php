<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class TransactionReportController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('create invoice', Auth::user());

        $createdUserHospital = Auth::user()->hospital->id;

        $startDate = Carbon::parse($request->from)
            ->startOfDay()
            ->toDateTimeString();

        $to = Carbon::parse($request->to)
            ->endOfDay()
            ->toDateTimeString();

        // get user today transactions
        $transactions = DB::table('transactions')
            ->where('hospital_id', $createdUserHospital)
            ->whereBetween('created_at', [$from, $to])
            ->get();

        dd($transactions);
    }
}
