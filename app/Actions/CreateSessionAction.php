<?php

namespace App\Actions;

use App\Constants\Statuses;
use App\Models\Invoice;
use App\Services\WebcheckoutService;
use Illuminate\Support\Str;

class CreateSessionAction
{
    public function handle(array $cartContent, int $id): ?Invoice
    {
        $sessionData = $this->getSessionData($cartContent);

        $session = (new WebcheckoutService())->createSession($sessionData);
        if (Statuses::OK===$session->status->status) {
            $products = $this->getProductCart($cartContent);

            $invoice = Invoice::create([
                'total' => $sessionData['payment']['amount']['total'],
                'payment_status'=> Statuses::PENDING,
                'url'=>$session->processUrl,
                'session_id'=>$session->requestId,
                'client_id'=> $id,
            ]);

            $invoice->save();

            $invoice->products()->attach($products);
        }
        return $invoice ?? null;
    }

    private function getSessionData(array $data): array
    {
        $description='';
        $total = 0;
        foreach ($data as $element) {
            $description = $description.'----'.'name:'.$element['name'].' cuantity:'.$element['qty'].' price:'.$element['price'];
            $total += $element['subtotal'];
        }
        $reference = Str::random(10);
        $amount = [
            'currency' => 'COP',
            'total' => $total,
        ];
        return [
            'payment' => [
                'reference' => $reference,
                'description' => $description,
                'amount' => $amount
            ],
            'returnUrl' => route('webcheckout.invoices'),
            'expiration' => date('c', strtotime('+10 minutes')),

        ];
    }

    private function getProductCart(array $data): array
    {
        $products = array();
        foreach ($data as $element) {
            $products[$element['id']]=[
                'quantity' => $element['qty'],
                'price' => $element['price'],
                'subtotal' => $element['subtotal'],
            ];
        }
        return $products;
    }
}
