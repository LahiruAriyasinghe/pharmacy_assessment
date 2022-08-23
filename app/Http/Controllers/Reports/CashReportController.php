<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use PDF;

class CashReportController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function daily(Request $request)
    {
        Gate::authorize('create invoice', Auth::user());

        $createdUser = Auth::user();
        $createdUserHospital = Auth::user()->hospital;

        $cashInHand = DB::table('transactions')
            ->where('created_user_id', Auth::id())
            ->where('type', 'cash')
            ->where('reversed', 0)
            ->whereDate('created_at', Carbon::now())
            ->sum(DB::raw('credit - debit'));

        $cashInCards = DB::table('transactions')
            ->where('created_user_id', Auth::id())
            ->where('type', 'card')
            ->where('reversed', 0)
            ->whereDate('created_at', Carbon::now())
            ->sum(DB::raw('credit - debit'));

        $cashReversed = DB::table('transactions')
            ->where('created_user_id', Auth::id())
            ->where('type', 'cash')
            ->where('reversed', 1)
            ->whereDate('created_at', Carbon::now())
            ->sum(DB::raw('debit - credit'));

        $cardReversed = DB::table('transactions')
            ->where('created_user_id', Auth::id())
            ->where('type', 'card')
            ->where('reversed', 1)
            ->whereDate('created_at', Carbon::now())
            ->sum(DB::raw('debit - credit'));

        $reportGeneratedPath = $this->generatePdf(
            $cashInHand, 
            $cashInCards, 
            $cashReversed, 
            $cardReversed, 
            $createdUser, 
            $createdUserHospital);

        return [
            'success' => true,
            'next' => null,
            'msg' => 'Report Generated successfully',
            'data' => [
                'cash_in_hand_url' => $reportGeneratedPath,
            ],
        ];
    }

    private function generatePdf($cashInHand, $cashInCards, $cashReversed, $cardReversed, $user, $hospital)
    {
        $pdfName = (string) Str::orderedUuid();
        $filePath = 'reports/' . $pdfName . '.pdf';
        $pdfStorePath = public_path() . '/' . $filePath;

        $pdf = PDF::loadView('reports.pdf.cashier', [
            'cashInHand' => $cashInHand,
            'cashInCards' => $cashInCards,
            'cashReversed' => $cashReversed,
            'cardReversed' => $cardReversed,
            'employee' => $user,
            'hospital' => $hospital,
        ])->setPaper('a6', 'portrait');

        \File::put($pdfStorePath, $pdf->output());

        return asset($filePath);
    }
}
