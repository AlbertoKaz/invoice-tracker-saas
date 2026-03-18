<?php

use App\Http\Controllers\StripeCheckoutController;
use App\Http\Controllers\StripeWebhookController;
use App\Livewire\Dashboard;
use App\Livewire\Clients\Index as ClientsIndex;
use App\Livewire\Clients\Create as ClientsCreate;
use App\Livewire\Clients\Edit as ClientsEdit;
use App\Livewire\Invoices\Index as InvoicesIndex;
use App\Livewire\Invoices\Create as InvoicesCreate;
use App\Livewire\Invoices\Show as InvoicesShow;
use App\Livewire\Invoices\Edit as InvoicesEdit;
use App\Models\Invoice;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoicePdfController;



Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('/clients', ClientsIndex::class)->name('clients.index');
    Route::get('/clients/create', ClientsCreate::class)->name('clients.create');
    Route::get('/clients/{client}/edit', ClientsEdit::class)->name('clients.edit');

    Route::get('/invoices', InvoicesIndex::class)->name('invoices.index');
    Route::get('/invoices/create', InvoicesCreate::class)->name('invoices.create');
    Route::get('/invoices/{invoice}', InvoicesShow::class)->name('invoices.show');
    Route::get('/invoices/{invoice}/edit', InvoicesEdit::class)->name('invoices.edit');
    Route::get('/invoices/{invoice}/pdf', InvoicePdfController::class)->name('invoices.pdf');

    Route::view('profile', 'profile')->name('profile');

});



Route::post('/invoices/{invoice}/checkout', StripeCheckoutController::class)
    ->name('stripe.checkout');

Route::get('/stripe/success/{invoice}', function (Invoice $invoice) {
    return view('stripe.success', compact('invoice'));
})->name('stripe.success');

Route::get('/stripe/cancel/{invoice}', function (Invoice $invoice) {
    return view('stripe.cancel', compact('invoice'));
})->name('stripe.cancel');




Route::post('/stripe/webhook', StripeWebhookController::class)
    ->name('stripe.webhook');


require __DIR__.'/auth.php';
