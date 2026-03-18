<x-app-layout>
    <div class="py-16">
        <div class="mx-auto max-w-2xl px-4 text-center">

            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-100">
                <svg class="h-8 w-8 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <h1 class="mt-6 text-3xl font-bold text-gray-900">
                Payment successful
            </h1>

            <p class="mt-2 text-sm text-gray-600">
                The invoice has been paid successfully.
            </p>

            <div class="mt-8">
                <a
                    href="{{ route('invoices.show', $invoice) }}"
                    class="inline-flex items-center rounded-xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500"
                >
                    Back to invoice
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
