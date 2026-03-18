<?php

namespace App\Livewire\Invoices;

use App\Models\Invoice;
use Livewire\Component;

class Show extends Component
{
    public Invoice $invoice;

    public function mount(Invoice $invoice): void
    {
        $this->invoice = $invoice->load(['client', 'items']);
    }

    public function render()
    {
        return view('livewire.invoices.show')->layout('layouts.app');
    }
}
