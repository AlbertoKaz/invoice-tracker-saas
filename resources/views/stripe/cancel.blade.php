<x-app-layout>
    <div class="py-16">
        <div class="mx-auto max-w-2xl px-4 text-center">

            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
                <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>

            <h1 class="mt-6 text-3xl font-bold text-gray-900">
                Payment cancelled
            </h1>

            <p class="mt-2 text-sm text-gray-600">
                The payment process was cancelled. You can try again anytime.
            </p>

            <div class="mt-8">
                <a
                    href="{{ route('invoices.show', $invoice) }}"
                    class="inline-flex items-center rounded-xl bg-gray-900 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-gray-800"
                >
                    Back to invoice
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
