<?php

namespace App\Jobs;

use App\Imports\CustomersImport;
use App\Mail\ImportCompleted;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ImportCustomersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function handle()
    {
        Excel::import(new CustomersImport, Storage::path($this->filePath));
        Storage::delete($this->filePath);
        Mail::to('ekroni99@gmail.com')->send(new ImportCompleted());
    }
}
