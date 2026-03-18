<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                Invoices
            </h1>
            <p class="mt-1 text-sm text-gray-600">
                Manage all your invoices from one place.
            </p>
        </div>

        <a
            href="{{ route('invoices.create') }}"
            class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500"
        >
            New Invoice
        </a>
    </div>

    @if (session()->has('success'))
        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        @if ($invoices->count())
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Invoice
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Client
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Issue Date
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Status
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Total
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Actions
                        </th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach ($invoices as $invoice)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <a
                                    href="{{ route('invoices.show', $invoice) }}"
                                    class="font-semibold text-gray-900 transition hover:text-indigo-600 hover:underline"
                                >
                                    {{ $invoice->invoice_number }}
                                </a>

                                @if($invoice->due_date)
                                    <div class="text-sm text-gray-500">
                                        Due: {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}
                                    </div>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $invoice->client->name ?? 'No client' }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($invoice->issue_date)->format('M d, Y') }}
                            </td>

                            <td class="px-6 py-4">
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
                            </td>

                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                €{{ number_format($invoice->total, 2) }}
                            </td>

                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a
                                        href="{{ route('invoices.show', $invoice) }}"
                                        class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                                    >
                                        View
                                    </a>

                                    @if ($invoice->status === \App\Models\Invoice::STATUS_DRAFT)
                                        <button
                                            type="button"
                                            wire:click="sendInvoice({{ $invoice->id }})"
                                            wire:confirm="Are you sure you want to mark this invoice as sent?"
                                            class="text-sm font-medium text-blue-600 transition hover:text-blue-500"
                                        >
                                            Send
                                        </button>
                                    @endif

                                    @if ($invoice->display_status !== \App\Models\Invoice::STATUS_PAID)
                                        <button
                                            type="button"
                                            wire:click="markAsPaid({{ $invoice->id }})"
                                            wire:confirm="Are you sure you want to mark this invoice as paid?"
                                            class="text-sm font-medium text-emerald-600 transition hover:text-emerald-500"
                                        >
                                            Mark as Paid
                                        </button>
                                    @endif

                                    <a
                                        href="{{ route('invoices.pdf', $invoice) }}"
                                        class="text-sm font-medium text-gray-600 transition hover:text-gray-500"
                                    >
                                        PDF
                                    </a>

                                    <a
                                        href="{{ route('invoices.edit', $invoice) }}"
                                        class="text-sm font-medium text-indigo-600 transition hover:text-indigo-500"
                                    >
                                        Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="px-6 py-16 text-center">
                <h2 class="text-lg font-semibold text-gray-900">
                    No invoices yet
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Create your first invoice to get started.
                </p>

                <div class="mt-6">
                    <a
                        href="{{ route('invoices.create') }}"
                        class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500"
                    >
                        Create First Invoice
                    </a>
                </div>
            </div>
        @endif

        <div class="border-t border-gray-200 bg-gray-50 px-6 py-4">
            {{ $invoices->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</div>
