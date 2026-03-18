<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">
            Create Invoice
        </h1>
        <p class="mt-1 text-sm text-gray-600">
            Create a new invoice with dynamic line items.
        </p>
    </div>

    @if (session()->has('success'))
        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit="save" class="space-y-8">
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">
                Invoice Details
            </h2>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="client_id" class="block text-sm font-medium text-gray-700 mb-2">Client</label>

                    @if($clients->isEmpty())
                        <div class="rounded-xl border border-yellow-200 bg-yellow-50 px-4 py-3 text-sm text-yellow-800">
                            You need to create a client before creating an invoice.
                        </div>

                        <div class="mt-3">
                            <a
                                href="{{ route('clients.create') }}"
                                class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500"
                            >
                                Create Client
                            </a>
                        </div>
                    @else
                        <select
                            id="client_id"
                            wire:model="client_id"
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            <option value="">Select a client</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                        @error('client_id') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    @endif
                </div>

                <div>
                    <label for="invoice_number" class="block text-sm font-medium text-gray-700 mb-2">Invoice Number</label>
                    <input
                        id="invoice_number"
                        type="text"
                        wire:model="invoice_number"
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                    @error('invoice_number') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="issue_date" class="block text-sm font-medium text-gray-700 mb-2">Issue Date</label>
                    <input
                        id="issue_date"
                        type="date"
                        wire:model="issue_date"
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                    @error('issue_date') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">Due Date</label>
                    <input
                        id="due_date"
                        type="date"
                        wire:model="due_date"
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                    @error('due_date') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select
                        id="status"
                        wire:model="status"
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        <option value="draft">Draft</option>
                        <option value="sent">Sent</option>
                        <option value="paid">Paid</option>
                        <option value="overdue">Overdue</option>
                    </select>
                    @error('status') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea
                        id="notes"
                        wire:model="notes"
                        rows="4"
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    ></textarea>
                    @error('notes') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">
                    Invoice Items
                </h2>

                <button
                    type="button"
                    wire:click="addItem"
                    class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500"
                >
                    Add Item
                </button>
            </div>

            <div class="space-y-4">
                @foreach ($items as $index => $item)
                    <div wire:key="invoice-item-{{ $index }}" class="grid grid-cols-1 gap-4 rounded-xl border border-gray-200 p-4 md:grid-cols-12">
                        <div class="md:col-span-5">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <input
                                type="text"
                                wire:model.live="items.{{ $index }}.description"
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                            @error("items.$index.description") <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Qty</label>
                            <input
                                type="number"
                                min="1"
                                step="1"
                                wire:model.live.debounce.300ms="items.{{ $index }}.quantity"
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                            @error("items.$index.quantity") <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Unit Price</label>
                            <input
                                type="number"
                                min="0"
                                step="0.01"
                                wire:model.live.debounce.300ms="items.{{ $index }}.unit_price"
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                            @error("items.$index.unit_price") <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Total</label>
                            <input
                                type="text"
                                value="${{ number_format($item['line_total'], 2) }}"
                                class="w-full rounded-xl border-gray-200 bg-gray-50 text-gray-700 shadow-sm"
                                readonly
                            >
                        </div>

                        <div class="md:col-span-1 flex items-end">
                            <button
                                type="button"
                                wire:click="removeItem({{ $index }})"
                                class="w-full rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-100"
                            >
                                Remove
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <div class="ml-auto max-w-sm space-y-3">
                <div class="flex items-center justify-between text-sm text-gray-600">
                    <span>Subtotal</span>
                    <span class="font-medium text-gray-900">${{ number_format($subtotal, 2) }}</span>
                </div>

                <div class="flex items-center justify-between text-sm text-gray-600">
                    <span>Tax</span>
                    <span class="font-medium text-gray-900">${{ number_format($tax_total, 2) }}</span>
                </div>

                <div class="flex items-center justify-between border-t border-gray-200 pt-3 text-base font-semibold text-gray-900">
                    <span>Total</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a
                href="{{ route('invoices.index') }}"
                class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500"
            >
                Save Invoice
            </button>
        </div>
    </form>
</div>
