<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ __('purchases.invoice_number') }} {{ $purchase->invoice_number }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; font-size: 14px; line-height: 1.6; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; }
        .header-table { width: 100%; margin-bottom: 30px; }
        .header-table td { vertical-align: top; }
        .company-name { font-size: 22px; font-weight: bold; color: #2c3e50; margin-bottom: 5px; }
        .invoice-title { font-size: 28px; font-weight: bold; color: #3498db; text-align: right; }
        .invoice-meta { text-align: right; color: #777; font-size: 13px; }
        .info-table { width: 100%; margin-bottom: 30px; }
        .info-table td { vertical-align: top; padding: 10px; }
        .info-box { background: #f8f9fa; border-radius: 5px; padding: 15px; }
        .info-box h4 { margin: 0 0 10px 0; color: #2c3e50; font-size: 14px; text-transform: uppercase; border-bottom: 2px solid #3498db; padding-bottom: 5px; }
        .info-box p { margin: 3px 0; font-size: 13px; }
        .details-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .details-table th { background: #3498db; color: #fff; padding: 10px 15px; text-align: left; font-size: 13px; text-transform: uppercase; }
        .details-table td { padding: 10px 15px; border-bottom: 1px solid #eee; }
        .details-table tr:nth-child(even) { background: #f8f9fa; }
        .totals-table { width: 350px; margin-left: auto; border-collapse: collapse; }
        .totals-table td { padding: 8px 15px; font-size: 14px; }
        .totals-table .label { text-align: right; color: #777; }
        .totals-table .value { text-align: right; font-weight: bold; }
        .totals-table .grand-total td { border-top: 2px solid #3498db; font-size: 18px; color: #2c3e50; }
        .footer { margin-top: 50px; text-align: center; color: #aaa; font-size: 11px; border-top: 1px solid #eee; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="invoice-box">
        {{-- Header --}}
        <table class="header-table">
            <tr>
                <td style="width: 60%;">
                    <div class="company-name">{{ $settings['company_name'] ?? __('settings.app_name') }}</div>
                    <div style="color: #777; font-size: 13px;">
                        {!! nl2br(e($settings['company_address'] ?? '')) !!}<br>
                        {{ $settings['company_phone'] ?? '' }}<br>
                        {{ $settings['company_email'] ?? '' }}
                    </div>
                </td>
                <td style="width: 40%;">
                    <div class="invoice-title">{{ __('purchases.purchase_invoice') }}</div>
                    <div class="invoice-meta">
                        <strong>{{ __('purchases.invoice_number') }}:</strong> {{ $purchase->invoice_number }}<br>
                        <strong>{{ __('purchases.date') }}:</strong> {{ $purchase->purchase_date->format('Y-m-d') }}
                    </div>
                </td>
            </tr>
        </table>

        {{-- Supplier Info --}}
        <table class="info-table">
            <tr>
                <td style="width: 50%;">
                    <div class="info-box">
                        <h4>{{ __('purchases.supplier') }}</h4>
                        <p><strong>{{ $purchase->supplier->name }}</strong></p>
                        @if($purchase->supplier->contact_name)
                            <p>{{ $purchase->supplier->contact_name }}</p>
                        @endif
                        @if($purchase->supplier->address)
                            <p>{!! nl2br(e($purchase->supplier->address)) !!}</p>
                        @endif
                        @if($purchase->supplier->phone)
                            <p>{{ $purchase->supplier->phone }}</p>
                        @endif
                        @if($purchase->supplier->email)
                            <p>{{ $purchase->supplier->email }}</p>
                        @endif
                    </div>
                </td>
                <td style="width: 50%;">
                    <div class="info-box">
                        <h4>{{ __('purchases.product') }}</h4>
                        <p><strong>{{ $purchase->product->name }}</strong></p>
                        <p>{{ __('products.reference') }}: {{ $purchase->product->reference }}</p>
                        @if($purchase->product->description)
                            <p>{{ $purchase->product->description }}</p>
                        @endif
                    </div>
                </td>
            </tr>
        </table>

        {{-- Purchase Details --}}
        <table class="details-table">
            <thead>
                <tr>
                    <th>{{ __('purchases.product') }}</th>
                    <th style="text-align: center;">{{ __('purchases.quantity') }}</th>
                    <th style="text-align: right;">{{ __('purchases.price') }}</th>
                    <th style="text-align: right;">{{ __('purchases.total') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        {{ $purchase->product->name }}<br>
                        <small style="color: #999;">{{ $purchase->product->reference }}</small>
                    </td>
                    <td style="text-align: center;">{{ $purchase->quantity }}</td>
                    <td style="text-align: right;">{{ number_format($purchase->purchase_price, 2) }} {{ $currency }}</td>
                    <td style="text-align: right;">{{ number_format($purchase->total, 2) }} {{ $currency }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Totals --}}
        <table class="totals-table">
            <tr>
                <td class="label">{{ __('purchases.subtotal') }}:</td>
                <td class="value">{{ number_format($purchase->total, 2) }} {{ $currency }}</td>
            </tr>
            <tr class="grand-total">
                <td class="label">{{ __('purchases.total') }}:</td>
                <td class="value">{{ number_format($purchase->total, 2) }} {{ $currency }}</td>
            </tr>
        </table>

        {{-- Footer --}}
        <div class="footer">
            {{ $settings['company_name'] ?? __('settings.app_name') }} &mdash; {{ __('purchases.generated_on') }} {{ now()->format('Y-m-d H:i') }}
        </div>
    </div>
</body>
</html>
