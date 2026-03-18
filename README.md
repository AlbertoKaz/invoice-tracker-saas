# Invoice Tracker SaaS (Laravel + Stripe)

A lightweight Invoice SaaS built with Laravel, Livewire and Stripe, featuring a complete billing workflow with real-time payment confirmation via webhooks.

## 🚀 Features

- Authentication (Laravel Breeze)
- Client management (CRUD)
- Invoice system (CRUD)
- Invoice items and totals
- Dashboard with metrics
- PDF invoice export
- Stripe Checkout integration (test mode)
- Webhook-based payment confirmation

## 🔄 Billing Workflow

1. Create clients
2. Generate invoices with items and totals
3. Pay invoices via Stripe Checkout
4. Stripe webhook confirms payment
5. Invoice is automatically marked as **paid**

## 💳 Stripe Integration

- Stripe Checkout for one-time payments
- Secure webhook handling 
- Automatic invoice status update (`paid`)
- Test environment ready (Stripe sandbox)

## 🛠️ Tech Stack

- Laravel 12
- Livewire 3
- TailwindCSS
- Stripe PHP SDK
- MySQL

## 🧱 Architecture

- MVC + Livewire components
- Stripe Checkout for payments
- Webhook-driven state management
- Clean separation via controllers (StripeWebhookController, StripeCheckoutController)

## 📦 Installation

```bash
git clone https://github.com/AlbertoKaz/invoice-saas.git
cd invoice-saas

composer install
cp .env.example .env
php artisan key:generate
