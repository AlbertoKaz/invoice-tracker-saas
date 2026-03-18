<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function delete(Client $client): void
    {
        abort_if($client->user_id !== Auth::id(), 403);

        $client->delete();

        session()->flash('success', 'Client deleted successfully.');
    }

    public function render()
    {
        $clients = Client::query()
            ->where('user_id', Auth::id())
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('company_name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.clients.index', [
            'clients' => $clients,
        ])->layout('layouts.app');
    }
}
