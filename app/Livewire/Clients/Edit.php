<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Edit extends Component
{
    public Client $client;

    public string $name = '';
    public string $company_name = '';
    public string $email = '';
    public string $phone = '';
    public string $tax_number = '';
    public string $address = '';
    public string $city = '';
    public string $postal_code = '';
    public string $country = '';
    public string $notes = '';

    public function mount(Client $client): void
    {
        abort_if($client->user_id !== Auth::id(), 403);

        $this->client = $client;
        $this->name = $client->name ?? '';
        $this->company_name = $client->company_name ?? '';
        $this->email = $client->email ?? '';
        $this->phone = $client->phone ?? '';
        $this->tax_number = $client->tax_number ?? '';
        $this->address = $client->address ?? '';
        $this->city = $client->city ?? '';
        $this->postal_code = $client->postal_code ?? '';
        $this->country = $client->country ?? '';
        $this->notes = $client->notes ?? '';
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'tax_number' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        $this->client->update($validated);

        session()->flash('success', 'Client updated successfully.');

        return $this->redirect(route('clients.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.clients.edit')
            ->layout('layouts.app');
    }
}
