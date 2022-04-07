<?php

namespace App\Actions;

use App\Models\Invoice;
use App\Services\WebcheckoutService;

class CheckStatusAction{

   public function handle(Invoice $invoice)
   {
      $statusinvoice = (new WebcheckoutService)->getInformation($invoice->session_id);
      //dd($invoice,$statusinvoice);
      $invoice->update(['payment_status' => $statusinvoice->status->status]);

   }

}