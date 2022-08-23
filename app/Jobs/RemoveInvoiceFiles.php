<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Invoice\InvoiceFile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class RemoveInvoiceFiles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $yesterday = Carbon::now()->subDay();

        // get last day invoice directory
        $directory = 'invoice-pdfs/' . $yesterday->toDateString();

        // remove files in directory
        Storage::disk('public')->deleteDirectory($directory);

        // remove last day invoice list
        $files = InvoiceFile::whereDate('created_at', $yesterday)
        ->delete();

        echo $directory;
    }
}
