<?php

namespace App\Jobs;

use App\Actions\CheckStatusAction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Invoice;

class CheckStatusJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

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
    public function handle(CheckStatusAction $actions): int
    {
        $invoices = Invoice::where('payment_status', '=', 'PENDING')->get();

        foreach ($invoices as $invoice) {
            $actions->handle($invoice);
        }
        return 0;
    }
}
