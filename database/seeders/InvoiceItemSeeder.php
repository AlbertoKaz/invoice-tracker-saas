<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Database\Seeder;

class InvoiceItemSeeder extends Seeder
{
    public function run(): void
    {
        $invoices = Invoice::all();

        foreach ($invoices as $invoice) {

            $subtotal = 0;

            $itemsCount = rand(1, 4);

            for ($i = 0; $i < $itemsCount; $i++) {

                $quantity = rand(1, 3);
                $unitPrice = rand(50, 300);

                $lineTotal = $quantity * $unitPrice;

                $subtotal += $lineTotal;

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'description' => collect([
                        'Web development',
                        'UI design',
                        'Bug fixing',
                        'Monthly maintenance',
                        'Consulting session',
                        'API integration',
                    ])->random(),
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'line_total' => $lineTotal,
                ]);
            }

            $tax = round($subtotal * 0.21, 2);
            $total = $subtotal + $tax;

            $invoice->update([
                'subtotal' => $subtotal,
                'tax_total' => $tax,
                'total' => $total,
            ]);
        }
    }
}
