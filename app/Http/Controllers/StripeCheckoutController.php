<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\RedirectResponse;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeCheckoutController extends Controller
{
    public function __invoke(Invoice $invoice): RedirectResponse
    {
        if ($invoice->status === Invoice::STATUS_PAID) {
            return redirect()
                ->route('invoices.show', $invoice)
                ->with('success', 'This invoice has already been paid.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Invoice #' . $invoice->invoice_number,
                    ],
                    'unit_amount' => (int) round($invoice->total * 100),
                ],
                'quantity' => 1,
            ]],
            'metadata' => [
                'invoice_id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
            ],
            'success_url' => route('stripe.success', $invoice),
            'cancel_url' => route('stripe.cancel', $invoice),
        ]);

        return redirect($session->url);
    }
}
