<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class Dashboard extends Component
{
    public int $totalClients = 0;
    public int $totalInvoices = 0;
    public int $paidInvoices = 0;
    public int $draftInvoices = 0;
    public int $sentInvoices = 0;
    public int $pendingInvoices = 0;
    public int $overdueInvoices = 0;

    public float $revenue = 0;

    public function mount(): void
    {
        $userId = Auth::id();

        $this->totalClients = Client::query()
            ->where('user_id', $userId)
            ->count();

        $this->totalInvoices = Invoice::query()
            ->where('user_id', $userId)
            ->count();

        $this->paidInvoices = Invoice::query()
            ->where('user_id', $userId)
            ->where('status', Invoice::STATUS_PAID)
            ->count();

        $this->draftInvoices = Invoice::query()
            ->where('user_id', $userId)
            ->where('status', Invoice::STATUS_DRAFT)
            ->count();

        $this->sentInvoices = Invoice::query()
            ->where('user_id', $userId)
            ->where('status', Invoice::STATUS_SENT)
            ->count();

        $this->pendingInvoices = Invoice::query()
            ->where('user_id', $userId)
            ->whereIn('status', [
                Invoice::STATUS_DRAFT,
                Invoice::STATUS_SENT,
                Invoice::STATUS_OVERDUE,
            ])
            ->count();

        $this->overdueInvoices = Invoice::query()
            ->where('user_id', $userId)
            ->where('status', '!=', Invoice::STATUS_PAID)
            ->whereDate('due_date', '<', now()->toDateString())
            ->count();

        $this->revenue = (float) Invoice::query()
            ->where('user_id', $userId)
            ->where('status', Invoice::STATUS_PAID)
            ->sum('total');
    }

    public function render(): View
    {
        return view('livewire.dashboard')
            ->layout('layouts.app');
    }
}
