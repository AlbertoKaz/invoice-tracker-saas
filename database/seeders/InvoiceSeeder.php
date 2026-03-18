<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\User;
use App\Models\Client;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (! $user) {
            return;
        }

        $clients = Client::where('user_id', $user->id)->get();

        if ($clients->isEmpty()) {
            return;
        }

        $invoiceNumber = 1;

        foreach ($clients as $client) {

            $invoiceCount = rand(2, 5);

            for ($i = 0; $i < $invoiceCount; $i++) {

                $issueDate = Carbon::now()->subDays(rand(0, 90));
                $dueDate = (clone $issueDate)->addDays(15);

                $status = collect(['draft', 'sent', 'paid', 'overdue'])->random();

                $paidAt = null;

                if ($status === 'paid') {
                    $paidAt = (clone $issueDate)->addDays(rand(1, 20));
                }

                $subtotal = rand(100, 1000);
                $tax = round($subtotal * 0.21, 2);
                $total = $subtotal + $tax;

                Invoice::create([
                    'user_id' => $user->id,
                    'client_id' => $client->id,
                    'invoice_number' => 'INV-' . date('Y') . '-' . str_pad($invoiceNumber++, 4, '0', STR_PAD_LEFT),
                    'issue_date' => $issueDate,
                    'due_date' => $dueDate,
                    'status' => $status,
                    'subtotal' => $subtotal,
                    'tax_total' => $tax,
                    'total' => $total,
                    'notes' => fake()->optional()->sentence(),
                    'paid_at' => $paidAt,
                ]);
            }
        }
    }
}
