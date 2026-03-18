<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111827;
            margin: 0;
            padding: 0;
        }

        .page {
            padding: 32px;
        }

        .header {
            margin-bottom: 32px;
        }

        .title {
            font-size: 28px;
            font-weight: bold;
            margin: 0 0 8px;
        }

        .muted {
            color: #6b7280;
            font-size: 12px;
        }

        .section {
            margin-bottom: 28px;
        }

        .grid {
            width: 100%;
        }

        .grid td {
            vertical-align: top;
            width: 50%;
        }

        .card-title {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #374151;
        }

        .info-line {
            margin-bottom: 5px;
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        table.items thead th {
            background: #f3f4f6;
            color: #374151;
            font-size: 12px;
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #d1d5db;
        }

        table.items tbody td {
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
        }

        .text-right {
            text-align: right;
        }

        .totals {
            width: 320px;
            margin-left: auto;
            margin-top: 24px;
            border-collapse: collapse;
        }

        .totals td {
            padding: 8px 0;
        }

        .totals .label {
            color: #6b7280;
        }

        .totals .value {
            text-align: right;
            font-weight: bold;
            color: #111827;
        }

        .totals .grand-total td {
            border-top: 1px solid #d1d5db;
            padding-top: 12px;
            font-size: 14px;
        }

        .status {
            display: inline-block;
            padding: 4px 10px;
            font-size: 11px;
            border-radius: 999px;
            font-weight: bold;
            text-transform: capitalize;
            background: #e5e7eb;
            color: #374151;
        }

        .status.sent {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .status.paid {
            background: #d1fae5;
            color: #047857;
        }

        .status.overdue {
            background: #fee2e2;
            color: #b91c1c;
        }

        .footer {
            margin-top: 40px;
            font-size: 11px;
            color: #6b7280;
        }

        .notes-box {
            margin-top: 12px;
            padding: 12px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
        }
    </style>
</head>
<body>
<div class="page">

    <div class="header">
        <h1 class="title">Invoice</h1>
        <div class="muted">{{ $invoice->invoice_number }}</div>
    </div>

    <div class="section">
        <table class="grid">
            <tr>
                <td>
                    <div class="card-title">Billed To</div>
                    <div class="info-line"><strong>{{ $invoice->client->name }}</strong></div>

                    @if($invoice->client->email)
                        <div class="info-line">{{ $invoice->client->email }}</div>
                    @endif
                </td>

                <td class="text-right">
                    <div class="card-title">Invoice Details</div>
                    <div class="info-line"><strong>Issue Date:</strong> {{ $invoice->issue_date?->format('M d, Y') }}</div>

                    @if($invoice->due_date)
                        <div class="info-line"><strong>Due Date:</strong> {{ $invoice->due_date->format('M d, Y') }}</div>
                    @endif

                    <div class="info-line">
                        <strong>Status:</strong>
                        <span class="status {{ $invoice->display_status }}">
                                {{ $invoice->display_status }}
                            </span>
                    </div>

                    @if($invoice->paid_at)
                        <div class="info-line"><strong>Paid At:</strong> {{ $invoice->paid_at->format('M d, Y H:i') }}</div>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="card-title">Items</div>

        <table class="items">
            <thead>
            <tr>
                <th>Description</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Unit Price</th>
                <th class="text-right">Line Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td class="text-right">{{ number_format($item->quantity, 0) }}</td>
                    <td class="text-right">${{ number_format((float) $item->unit_price, 2) }}</td>
                    <td class="text-right">${{ number_format((float) $item->line_total, 2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <table class="totals">
            <tr>
                <td class="label">Subtotal</td>
                <td class="value">${{ number_format((float) $invoice->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td class="label">Tax</td>
                <td class="value">${{ number_format((float) $invoice->tax_total, 2) }}</td>
            </tr>
            <tr class="grand-total">
                <td><strong>Total</strong></td>
                <td class="value">${{ number_format((float) $invoice->total, 2) }}</td>
            </tr>
        </table>
    </div>

    @if($invoice->notes)
        <div class="section">
            <div class="card-title">Notes</div>
            <div class="notes-box">
                {{ $invoice->notes }}
            </div>
        </div>
    @endif

    <div class="footer">
        Generated from Invoice Tracker SaaS.
    </div>

</div>
</body>
</html>
