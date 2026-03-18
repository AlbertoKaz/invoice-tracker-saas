<?php

namespace App\Livewire\Invoices;

use App\Models\Invoice;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public int $perPage = 5;

    public function sendInvoice(int $invoiceId): void
    {
        $invoice = Invoice::query()
            ->where('user_id', auth()->id())
            ->findOrFail($invoiceId);

        if ($invoice->status !== Invoice::STATUS_DRAFT) {
            return;
        }

        $invoice->update([
            'status' => Invoice::STATUS_SENT,
            'paid_at' => null,
        ]);

        session()->flash('success', 'Invoice marked as sent.');
    }

    public function markAsPaid(int $invoiceId): void
    {
        $invoice = Invoice::query()
            ->where('user_id', auth()->id())
            ->findOrFail($invoiceId);

        $invoice->update([
            'status' => Invoice::STATUS_PAID,
            'paid_at' => now(),
        ]);

        session()->flash('success', 'Invoice marked as paid.');
    }

    public function render()
    {
        $invoices = Invoice::query()
            ->with('client')
            ->where('user_id', auth()->id())
            ->latest('issue_date')
            ->paginate($this->perPage);

        return view('livewire.invoices.index', [
            'invoices' => $invoices,
        ])->layout('layouts.app');
    }
}
