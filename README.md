# 🚀 Invoice Tracker SaaS (Laravel + Livewire + Stripe)

A modern billing SaaS application built with Laravel, Livewire and Stripe.
Designed to demonstrate a complete real-world invoicing workflow, including payment processing and webhook-driven state management.

---

## ✨ Features

* 🔐 Authentication system (Laravel Breeze)
* 👥 Client management (full CRUD)
* 🧾 Invoice management (create, edit, track)
* 📦 Dynamic invoice items with automatic totals
* 📊 Dashboard with key metrics
* 📄 PDF invoice export
* 💳 Stripe Checkout integration (sandbox ready)
* 🔔 Webhook-based payment confirmation
* ✅ Automatic invoice status updates

---

## 🔄 Billing Workflow

1. Create and manage clients
2. Generate invoices with items and totals
3. Pay invoices via Stripe Checkout
4. Stripe sends webhook confirmation
5. Invoice is automatically marked as **paid**

---

## 💳 Stripe Integration

* Stripe Checkout for secure payments
* Webhook handling for payment confirmation
* Automatic invoice state synchronization
* Fully compatible with Stripe test environment

---

## 🛠️ Tech Stack

* **Laravel 12**
* **Livewire 3**
* **TailwindCSS**
* **Stripe PHP SDK**
* **MySQL**

---

## 🧱 Architecture

* MVC + Livewire components
* Event-driven payment flow (Stripe Webhooks)
* Clean separation of concerns:

    * `StripeCheckoutController`
    * `StripeWebhookController`
* Scalable SaaS-ready structure

---

## 📸 Screenshots (coming soon)

> Add screenshots here to showcase:
>
> * Dashboard
> * Invoice creation
> * Stripe checkout flow

---

## ⚙️ Installation

```bash
git clone https://github.com/AlbertoKaz/invoice-tracker-saas.git
cd invoice-tracker-saas

composer install
npm install

cp .env.example .env
php artisan key:generate

php artisan migrate --seed

npm run build
php artisan serve
```

---

## 🔑 Environment Setup

Configure your `.env` file:

```env
DB_DATABASE=invoice_tracker
DB_USERNAME=root
DB_PASSWORD=

STRIPE_KEY=your_test_key
STRIPE_SECRET=your_test_secret
```

---

## 🧪 Stripe Webhook Setup (Local)

Use Stripe CLI:

```bash
stripe listen --forward-to localhost:8000/stripe/webhook
```

---

## 📌 Roadmap

* [ ] Invoice edit & advanced states
* [ ] Payment history tracking
* [ ] Multi-user / team accounts
* [ ] Subscription billing (Stripe Billing)
* [ ] Email notifications

---

## 🤝 About the Project

This project was built as part of a SaaS-focused portfolio, aiming to demonstrate:

* Real-world billing logic
* Stripe integration
* Clean Laravel architecture
* Scalable application design

---

## 📬 Contact

Developed by **Alberto Mendoza**
Fullstack Laravel Developer

---

⭐ If you like this project, feel free to star the repository!

