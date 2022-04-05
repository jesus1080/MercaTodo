<?php

namespace App\Http\Controllers\Invoice;


use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Services\WebcheckoutService;
use App\Models\Invoice;
use Illuminate\Support\Str;

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
        if('OK'===$session->status->status){
            $invoice = Invoice::create([
                'total' => $sessionData['payment']['amount']['total'],
                'payment_status'=> 'PENDING',
            ]);
            $invoice->save();
            return redirect()->away($session->processUrl);
            
        }
        return redirect()->route('cart-content.index');
    }

    private function getProductCart(array $data){
        $products = array();
        foreach($data as $element){
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
        foreach($data as $element){
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
            'returnUrl' => 'http://127.0.0.1:8000/products-client',
            'expiration' => date('c',strtotime('+2 days')),

        ];
    }
}