<?php

namespace App\Livewire\Invoices;

use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Validation\Rule;

class Create extends Component
{
    public $client_id = '';
    public $invoice_number = '';
    public $issue_date = '';
    public $due_date = '';
    public $status = 'draft';
    public $notes = '';

    public $items = [];

    public $subtotal = 0;
    public $tax_total = 0;
    public $total = 0;

    public function mount(): void
    {
        $this->issue_date = now()->format('Y-m-d');
        $this->invoice_number = $this->generateInvoiceNumber();

        $this->items = [
            [
                'description' => '',
                'quantity' => 1,
                'unit_price' => 0,
                'line_total' => 0,
            ]
        ];

        $this->calculateTotals();
    }

    public function addItem(): void
    {
        $this->items[] = [
            'description' => '',
            'quantity' => 1,
            'unit_price' => 0,
            'line_total' => 0,
        ];

        $this->calculateTotals();
    }

    public function removeItem($index): void
    {
        if (count($this->items) === 1) {
            return;
        }

        unset($this->items[$index]);
        $this->items = array_values($this->items);

        $this->calculateTotals();
    }

    public function updated($property): void
    {
        if (str_starts_with($property, 'items.')) {
            $this->calculateTotals();
        }
    }

    public function calculateTotals(): void
    {
        $subtotal = 0;

        foreach ($this->items as $index => $item) {
            $quantity = is_numeric($item['quantity']) ? (float) $item['quantity'] : 0;
            $unitPrice = is_numeric($item['unit_price']) ? (float) $item['unit_price'] : 0;

            $lineTotal = $quantity * $unitPrice;

            $this->items[$index]['line_total'] = round($lineTotal, 2);
            $subtotal += $lineTotal;
        }

        $this->subtotal = round($subtotal, 2);
        $this->tax_total = 0;
        $this->total = round($this->subtotal + $this->tax_total, 2);
    }

    public function save()
    {
        $this->calculateTotals();

        $validated = $this->validate([
            'client_id' => [
                'required',
                Rule::exists('clients', 'id')->where(function ($query) {
                    $query->where('user_id', auth()->id());
                }),
            ],
            'invoice_number' => ['required', 'string', 'max:255', 'unique:invoices,invoice_number'],
            'issue_date' => ['required', 'date'],
            'due_date' => ['nullable', 'date', 'after_or_equal:issue_date'],
            'status' => ['required', 'in:draft,sent,paid,overdue'],
            'notes' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.description' => ['required', 'string', 'max:255'],
            'items.*.quantity' => ['required', 'numeric', 'min:1'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0'],
        ]);

        DB::transaction(function () use ($validated) {
            $invoice = Invoice::create([
                'user_id' => auth()->id(),
                'client_id' => $validated['client_id'],
                'invoice_number' => $validated['invoice_number'],
                'issue_date' => $validated['issue_date'],
                'due_date' => $validated['due_date'],
                'status' => $validated['status'],
                'subtotal' => $this->subtotal,
                'tax_total' => $this->tax_total,
                'total' => $this->total,
                'notes' => $validated['notes'] ?? null,
                'paid_at' => $validated['status'] === 'paid' ? now() : null,
            ]);

            foreach ($this->items as $item) {
                $quantity = (float) $item['quantity'];
                $unitPrice = (float) $item['unit_price'];
                $lineTotal = round($quantity * $unitPrice, 2);

                $invoice->items()->create([
                    'description' => $item['description'],
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'line_total' => $lineTotal,
                ]);
            }
        });

        session()->flash('success', 'Invoice created successfully.');

        $this->redirectRoute('invoices.index', navigate: true);
    }

    protected function generateInvoiceNumber(): string
    {
        $lastInvoice = Invoice::latest('id')->first();
        $nextNumber = $lastInvoice ? $lastInvoice->id + 1 : 1;

        return 'INV-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }


    public function render()
    {
        return view('livewire.invoices.create', [
            'clients' => Client::query()
                ->where('user_id', auth()->id())
                ->orderBy('name')
                ->get(),
        ])->layout('layouts.app');
    }
}
