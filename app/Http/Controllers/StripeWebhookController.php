<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $signature, $secret);
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // 🎯 Evento clave
        if ($event->type === 'checkout.session.completed') {

            $session = $event->data->object;

            $invoiceId = $session->metadata->invoice_id ?? null;

            if ($invoiceId) {

                $invoice = Invoice::find($invoiceId);

                if ($invoice && $invoice->status !== Invoice::STATUS_PAID) {
                    $invoice->update([
                        'status' => Invoice::STATUS_PAID,
                        'paid_at' => now(),
                    ]);
                }
            }
        }

        return response()->json(['success' => true]);
    }
}
