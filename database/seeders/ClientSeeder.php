<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (! $user) {
            return;
        }

        $clients = [
            [
                'name' => 'John Carter',
                'company_name' => 'BlueWave Studio',
                'email' => 'john@bluewavestudio.com',
                'phone' => '+1 202 555 0147',
                'tax_number' => 'ESA12345678',
                'address' => '1458 Market Street',
                'city' => 'San Francisco',
                'postal_code' => '94103',
                'country' => 'United States',
                'notes' => 'Main recurring client for branding and UI work.',
            ],
            [
                'name' => 'Emma Wilson',
                'company_name' => 'Northwind Goods',
                'email' => 'emma@northwindgoods.com',
                'phone' => '+44 20 7946 0958',
                'tax_number' => 'GB123456789',
                'address' => '22 Baker Street',
                'city' => 'London',
                'postal_code' => 'NW1 6XE',
                'country' => 'United Kingdom',
                'notes' => 'Usually requests monthly maintenance invoices.',
            ],
            [
                'name' => 'Lucas Martin',
                'company_name' => null,
                'email' => 'lucas.martin@example.com',
                'phone' => '+34 600 123 456',
                'tax_number' => '12345678Z',
                'address' => 'Calle Mayor 18',
                'city' => 'Madrid',
                'postal_code' => '28013',
                'country' => 'Spain',
                'notes' => 'Private client for consulting sessions.',
            ],
            [
                'name' => 'Sophie Laurent',
                'company_name' => 'Atelier Nova',
                'email' => 'hello@ateliernova.fr',
                'phone' => '+33 1 42 68 53 00',
                'tax_number' => 'FR12345678901',
                'address' => '14 Rue de Rivoli',
                'city' => 'Paris',
                'postal_code' => '75004',
                'country' => 'France',
                'notes' => 'Design-focused client with occasional urgent requests.',
            ],
            [
                'name' => 'Daniel Fischer',
                'company_name' => 'Fischer Tech',
                'email' => 'daniel@fischertech.de',
                'phone' => '+49 30 12345678',
                'tax_number' => 'DE123456789',
                'address' => 'Alexanderplatz 9',
                'city' => 'Berlin',
                'postal_code' => '10178',
                'country' => 'Germany',
                'notes' => 'Needs invoices with full tax details.',
            ],
            [
                'name' => 'Olivia Brown',
                'company_name' => 'Olivia Brown Media',
                'email' => 'contact@oliviabrownmedia.com',
                'phone' => '+1 310 555 0199',
                'tax_number' => 'US987654321',
                'address' => '860 Sunset Blvd',
                'city' => 'Los Angeles',
                'postal_code' => '90028',
                'country' => 'United States',
                'notes' => 'Social media campaigns and content planning.',
            ],
            [
                'name' => 'Marco Rossi',
                'company_name' => 'Rossi Creative',
                'email' => 'marco@rossicreative.it',
                'phone' => '+39 06 69876543',
                'tax_number' => 'IT12345678901',
                'address' => 'Via del Corso 101',
                'city' => 'Rome',
                'postal_code' => '00186',
                'country' => 'Italy',
                'notes' => 'Requests itemized invoices for each milestone.',
            ],
            [
                'name' => 'Alicia Navarro',
                'company_name' => null,
                'email' => 'alicia.navarro@example.com',
                'phone' => '+34 611 222 333',
                'tax_number' => '23456789X',
                'address' => 'Avenida Diagonal 320',
                'city' => 'Barcelona',
                'postal_code' => '08013',
                'country' => 'Spain',
                'notes' => 'Personal client, mostly one-off design tasks.',
            ],
        ];

        foreach ($clients as $client) {
            Client::create([
                'user_id' => $user->id,
                'name' => $client['name'],
                'company_name' => $client['company_name'],
                'email' => $client['email'],
                'phone' => $client['phone'],
                'tax_number' => $client['tax_number'],
                'address' => $client['address'],
                'city' => $client['city'],
                'postal_code' => $client['postal_code'],
                'country' => $client['country'],
                'notes' => $client['notes'],
            ]);
        }
    }
}
