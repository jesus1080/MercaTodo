<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Services\WebcheckoutService;
use App\Models\Invoice;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $cartContent = Cart::content()->toArray();
        $products = $this->getProductCart($cartContent);
        //dd($cartContent->toArray());
        Cart::destroy();
        $sessionData = $this->getSessionData($cartContent);
        $session = (new WebcheckoutService())->createSession($sessionData);
        //dd($session);
        if ('OK'===$session->status->status) {
            $invoice = Invoice::create([
                'total' => $sessionData['payment']['amount']['total'],
                'payment_status'=> 'PENDING',
                'url'=>$session->processUrl,
                'session_id'=>$session->requestId,
            ]);
            $invoice->save();
            return redirect()->away($session->processUrl);
        }
        return redirect()->route('cart-content.index');
    }

    private function getProductCart(array $data)
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
            //'returnUrl' => 'http://127.0.0.1:8000/products-client',
            'returnUrl' => route('webcheckout.invoices'),
            'expiration' => date('c', strtotime('+10 minutes')),

        ];
    }

    public function indexInvoices(): Response
    {
        $invoices = Invoice::paginate();
        return Inertia::render('Invoice/Invoices', compact('invoices'));
    }
}
