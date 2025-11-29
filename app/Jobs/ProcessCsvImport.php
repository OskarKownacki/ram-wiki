<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessCsvImport implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
}
