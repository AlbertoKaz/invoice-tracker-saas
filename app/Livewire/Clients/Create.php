<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
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

    public function save(): null
    {
        $validated = $this->validate();

        Client::create([
            ...$validated,
            'user_id' => Auth::id(),
        ]);

        session()->flash('success', 'Client created successfully.');

        return $this->redirect(route('clients.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.clients.create')
            ->layout('layouts.app');
    }
}
