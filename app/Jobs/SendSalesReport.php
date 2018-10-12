<?php

namespace App\Jobs;

use App\Models\Vendor;
use App\Notifications\Notify;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendSalesReport implements ShouldQueue
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
        $vendors = Vendor::all();
        $date = date('Y-m-d');

        foreach ($vendors as $vendor)
        {
            Notify::sendSalesReport($vendor, $date);
        }

    }
}
