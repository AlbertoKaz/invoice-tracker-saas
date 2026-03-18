<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $invoices = Invoice::all();

        foreach ($invoices as $invoice) {
            if ($invoice->status === 'paid') {
                Payment::create([
                    'invoice_id' => $invoice->id,
                    'stripe_payment_intent_id' => 'pi_' . Str::lower(Str::random(24)),
                    'amount' => $invoice->total,
                    'currency' => 'EUR',
                    'status' => 'succeeded',
                    'paid_at' => $invoice->paid_at ?? now()->subDays(rand(1, 30)),
                    'metadata' => json_encode([
                        'source' => 'seeder',
                        'type' => 'full_payment',
                    ]),
                ]);
            }

            if ($invoice->status === 'sent' && rand(0, 1)) {
                Payment::create([
                    'invoice_id' => $invoice->id,
                    'stripe_payment_intent_id' => 'pi_' . Str::lower(Str::random(24)),
                    'amount' => round($invoice->total / 2, 2),
                    'currency' => 'EUR',
                    'status' => 'pending',
                    'paid_at' => null,
                    'metadata' => json_encode([
                        'source' => 'seeder',
                        'type' => 'partial_or_pending_payment',
                    ]),
                ]);
            }
        }
    }
}
