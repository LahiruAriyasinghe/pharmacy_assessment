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

class AdminCashReportController extends Controller
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

        $startTime = $request->pdf_date;

        if (!$startTime) {
            $formattedDateTime = Carbon::now()->toDateTimeString();
        } else {
            $formattedDateTime = Carbon::parse($startTime)->toDateTimeString();
        }
        $employees = User::permission('create invoice')
            ->where('hospital_id', $createdUserHospital->id)
            ->withTrashed()
            ->get();

        $totals = [
            'cash' => 0,
            'card' => 0,
            'total' => 0,
        ];

        $employees->map(function ($employee) use ($totals, $formattedDateTime) {
            $sumCash = DB::table('transactions')
                ->where('created_user_id', $employee->id)
                ->where('type', 'cash')
                ->whereDate('created_at', $formattedDateTime)
                ->sum(DB::raw('credit - debit'));
            $sumCard = DB::table('transactions')
                ->where('created_user_id', $employee->id)
                ->where('type', 'card')
                ->whereDate('created_at', $formattedDateTime)
                ->sum(DB::raw('credit - debit'));
            $employee['sum_cash'] = $sumCash;
            $employee['sum_card'] = $sumCard;
            $employee['total'] = $sumCash + $sumCard;

            return $employee;
        });

        foreach ($employees as $key => $employee) {
            $totals['cash'] += $employee->sum_cash;
            $totals['card'] += $employee->sum_card;
            $totals['total'] += $employee->total;
        }

        $reportGeneratedPath = $this->generatePdf($employees, $totals, $createdUser, $createdUserHospital, $formattedDateTime);

        return [
            'success' => true,
            'next' => null,
            'msg' => 'Report Generated successfully',
            'data' => [
                'cash_in_hand_url' => $reportGeneratedPath,
            ],
        ];
    }

    private function generatePdf($employees, $totals, $user, $hospital, $reportDate)
    {
        $pdfName = (string) Str::orderedUuid();
        $filePath = 'reports/' . $pdfName . '.pdf';
        $pdfStorePath = public_path() . '/' . $filePath;

        $pdf = PDF::loadView('reports.pdf.admin', [
            'employees' => $employees,
            'totals' => $totals,
            'user' => $user,
            'hospital' => $hospital,
            'date' => $reportDate,
        ])->setPaper('a6', 'portrait');

        \File::put($pdfStorePath, $pdf->output());

        return asset($filePath);
    }
}
