<div class="py-10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
            <p class="mt-1 text-sm text-gray-600">
                Welcome back. Here is a quick overview of your billing activity.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Total Revenue</p>
                <p class="mt-2 text-3xl font-semibold text-gray-900">€{{ number_format($revenue, 2) }}</p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Total Clients</p>
                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $totalClients }}</p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Total Invoices</p>
                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $totalInvoices }}</p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Paid Invoices</p>
                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $paidInvoices }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Draft Invoices</p>
                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $draftInvoices }}</p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Sent Invoices</p>
                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $sentInvoices }}</p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Pending Invoices</p>
                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $pendingInvoices }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900">Payment Status</h2>
                <p class="mt-1 text-sm text-gray-600">
                    Quick snapshot of your invoice collection performance.
                </p>

                <div class="mt-6 space-y-4">
                    <div class="flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3">
                        <span class="text-sm font-medium text-gray-600">Paid</span>
                        <span class="text-base font-semibold text-emerald-600">{{ $paidInvoices }}</span>
                    </div>

                    <div class="flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3">
                        <span class="text-sm font-medium text-gray-600">Pending</span>
                        <span class="text-base font-semibold text-amber-600">{{ $pendingInvoices }}</span>
                    </div>

                    <div class="flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3">
                        <span class="text-sm font-medium text-gray-600">Overdue</span>
                        <span class="text-base font-semibold text-red-600">{{ $overdueInvoices }}</span>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
                <p class="mt-1 text-sm text-gray-600">
                    Jump into the most common tasks.
                </p>

                <div class="mt-6 flex flex-col gap-3">
                    <a
                        href="{{ route('clients.create') }}"
                        class="inline-flex items-center justify-center rounded-xl bg-white px-4 py-3 text-sm font-semibold text-gray-700 border border-gray-300 shadow-sm hover:bg-gray-50 transition"
                    >
                        Create Client
                    </a>

                    <a
                        href="{{ route('invoices.create') }}"
                        class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition"
                    >
                        Create Invoice
                    </a>

                    <a
                        href="{{ route('invoices.index') }}"
                        class="inline-flex items-center justify-center rounded-xl bg-white px-4 py-3 text-sm font-semibold text-gray-700 border border-gray-300 shadow-sm hover:bg-gray-50 transition"
                    >
                        View All Invoices
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
