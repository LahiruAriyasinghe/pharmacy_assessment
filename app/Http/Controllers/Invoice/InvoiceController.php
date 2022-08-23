<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Transaction;

class InvoiceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getLastInvoice(Request $request)
    {
        $user = Auth::user();
        Gate::authorize('create invoice', $user);

        // get last transaction
        $transaction = Transaction::where('created_user_id', $user->id)
               ->orderBy('id', 'desc')
               ->first();

        try {
            // select invoice pdf file
            $pdfFile = $transaction->invoice->pdfFile;
        } catch (\Throwable $th) {
            //throw $th;
            return [
                'success' => false,
                'next' => route('invoice'),
                'msg' => 'Sorry! cannot find any invoices',
            ];
        }


        return [
            'success' => true,
            'next' => route('invoice'),
            'msg' => 'Last invoice id is ' . $transaction->invoice_id,
            'data' => [
                'invoice_pdf_url' => $pdfFile->path,
            ],
        ];
    }
}
