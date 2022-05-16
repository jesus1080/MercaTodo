<?php

namespace App\Http\Controllers\Invoice;

use App\Actions\CreateSessionAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Services\WebcheckoutService;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class InvoiceController extends Controller
{
    public function store(Request $request, CreateSessionAction $sessionAction)
    {
        $cartContent = Cart::content()->toArray();


        if ($cartContent) {
            Cart::destroy();
            $invoice = $sessionAction->handle($cartContent, auth()->user()->id);

            if ($invoice) {
                return response()->json(['proccessUrl' => $invoice->url]);
            }
        }


        return response()->setStatusCode(400)->json([]);
        //return redirect()->route('webcheckout.invoices');
    }

    public function indexInvoices(): Response
    {
        $invoices = Invoice::where('client_id', '=', auth()->user()->id)->paginate();
        return Inertia::render('Invoice/Invoices', compact('invoices'));
    }

    public function show(int $id): Response
    {
        $invoice = Invoice::find($id);
        $products = Invoice::find($id)->products;
        $client = Invoice::find($id)->client;

        return Inertia::render('Invoice/InvoiceShow', compact('products', 'client', 'invoice'));
    }
}
