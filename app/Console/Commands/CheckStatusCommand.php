<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invoice;
use App\Jobs\CheckStatusJob;

class CheckStatusCommand extends Command
{
   
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:checkstatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check status of the invoice';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //dispatch_sync(new CheckStatusJob());
        CheckStatusJob::dispatch();
    }
}
