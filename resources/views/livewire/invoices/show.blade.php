<div class="py-10">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 space-y-6">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Invoice {{ $invoice->invoice_number }}</h1>
                <p class="mt-1 text-sm text-gray-600">
                    Detailed view of the invoice and payment status.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a
                    href="{{ route('invoices.index') }}"
                    class="inline-flex items-center rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50"
                >
                    Back
                </a>

                <a
                    href="{{ route('invoices.edit', $invoice) }}"
                    class="inline-flex items-center rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50"
                >
                    Edit
                </a>

                @if($invoice->status !== \App\Models\Invoice::STATUS_PAID)
                    <form action="{{ route('stripe.checkout', $invoice) }}" method="POST">
                        @csrf

                        <button
                            type="submit"
                            class="inline-flex items-center rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500"
                        >
                            Pay with Stripe
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Invoice Details</h2>
                        <p class="mt-1 text-sm text-gray-600">
                            Overview of the issued invoice.
                        </p>
                    </div>

                    @php
                        $displayStatus = $invoice->display_status;

                        $statusClasses = match ($displayStatus) {
                            \App\Models\Invoice::STATUS_DRAFT => 'bg-gray-100 text-gray-700',
                            \App\Models\Invoice::STATUS_SENT => 'bg-blue-100 text-blue-700',
                            \App\Models\Invoice::STATUS_PAID => 'bg-emerald-100 text-emerald-700',
                            \App\Models\Invoice::STATUS_OVERDUE => 'bg-red-100 text-red-700',
                            default => 'bg-gray-100 text-gray-700',
                        };
                    @endphp

                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold capitalize {{ $statusClasses }}">
                        {{ $displayStatus }}
                    </span>
                </div>

                <dl class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="rounded-xl bg-gray-50 p-4">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">Client</dt>
                        <dd class="mt-1 text-sm font-medium text-gray-900">
                            {{ $invoice->client->name ?? 'No client assigned' }}
                        </dd>
                    </div>

                    <div class="rounded-xl bg-gray-50 p-4">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">Email</dt>
                        <dd class="mt-1 text-sm font-medium text-gray-900">
                            {{ $invoice->client->email ?? '—' }}
                        </dd>
                    </div>

                    <div class="rounded-xl bg-gray-50 p-4">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">Issue Date</dt>
                        <dd class="mt-1 text-sm font-medium text-gray-900">
                            {{ optional($invoice->issue_date)->format('d/m/Y') ?? '—' }}
                        </dd>
                    </div>

                    <div class="rounded-xl bg-gray-50 p-4">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">Due Date</dt>
                        <dd class="mt-1 text-sm font-medium text-gray-900">
                            {{ optional($invoice->due_date)->format('d/m/Y') ?? '—' }}
                        </dd>
                    </div>
                </dl>

                <div class="mt-8">
                    <h3 class="text-base font-semibold text-gray-900">Invoice Items</h3>

                    <div class="mt-4 overflow-hidden rounded-xl border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Description
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Qty
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Unit Price
                                </th>
                                <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Amount
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($invoice->items as $item)
                                <tr>
                                    <td class="px-4 py-4 text-sm text-gray-900">
                                        {{ $item->description }}
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-600">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-600">
                                        €{{ number_format($item->unit_price, 2) }}
                                    </td>
                                    <td class="px-4 py-4 text-right text-sm font-medium text-gray-900">
                                        €{{ number_format($item->quantity * $item->unit_price, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-sm text-gray-500">
                                        No invoice items found.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900">Summary</h2>
                <p class="mt-1 text-sm text-gray-600">
                    Invoice totals and payment information.
                </p>

                <div class="mt-6 space-y-4">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium text-gray-900">€{{ number_format($invoice->subtotal, 2) }}</span>
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Tax</span>
                        <span class="font-medium text-gray-900">€{{ number_format($invoice->tax_amount, 2) }}</span>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex items-center justify-between">
                            <span class="text-base font-semibold text-gray-900">Total</span>
                            <span class="text-xl font-bold text-gray-900">€{{ number_format($invoice->total, 2) }}</span>
                        </div>
                    </div>
                </div>

                @if($invoice->status === \App\Models\Invoice::STATUS_PAID)
                    <div class="mt-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                        This invoice has already been paid.
                    </div>
                @else
                    <div class="mt-6 rounded-xl border border-indigo-200 bg-indigo-50 px-4 py-3 text-sm text-indigo-700">
                        This invoice is pending payment.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
