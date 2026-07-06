<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ __('invoices.invoice_number') }} {{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; font-size: 16px; line-height: 24px; }
        .invoice-box table { width: 100%; line-height: inherit; text-align: left; border-collapse: collapse; }
        .invoice-box table td { padding: 5px; vertical-align: top; }
        .invoice-box table tr td:nth-child(2) { text-align: right; }
        .invoice-box table tr.top table td { padding-bottom: 20px; }
        .invoice-box table tr.information table td { padding-bottom: 40px; }
        .invoice-box table tr.heading td { background: #eee; border-bottom: 1px solid #ddd; font-weight: bold; }
        .invoice-box table tr.details td { padding-bottom: 20px; }
        .invoice-box table tr.item td { border-bottom: 1px solid #eee; }
        .invoice-box table tr.item.last td { border-bottom: none; }
        .invoice-box table tr.total td:nth-child(2) { border-top: 2px solid #eee; font-weight: bold; }
        .header { text-align: right; color: #999; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table>
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <h2>{{ $settings['company_name'] ?? __('settings.app_name') }}</h2>
                            </td>
                            <td class="header">
                                {{ __('invoices.invoice_number') }}: {{ $invoice->invoice_number }}<br>
                                {{ __('invoices.date') }}: {{ $invoice->created_at->format('Y-m-d') }}<br>
                                {{ __('invoices.period_start') }} / {{ __('invoices.period_end') }}: {{ $invoice->period_start ? $invoice->period_start->format('Y-m-d') . ' - ' . $invoice->period_end->format('Y-m-d') : '-' }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <strong>{{ $settings['company_name'] ?? __('settings.app_name') }}</strong><br>
                                {!! nl2br(e($settings['company_address'] ?? '')) !!}<br>
                                {{ $settings['company_email'] ?? '' }}<br>
                                {{ $settings['company_phone'] ?? '' }}
                            </td>
                            <td>
                                @if($invoice->invoice_type == 'contact')
                                    <strong>{{ $invoice->contact->full_name }}</strong><br>
                                    {{ $invoice->contact->address }}<br>
                                    {{ $invoice->contact->email }}
                                @else
                                    <strong>{{ $invoice->supplier->name }}</strong><br>
                                    {{ $invoice->supplier->address }}<br>
                                    {{ $invoice->supplier->email }}
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <td>{{ __('invoices.description') }}</td>
                <td>{{ __('invoices.total') }}</td>
            </tr>
            <tr class="item">
                <td>
                    @if($invoice->invoice_type == 'contact')
                        {{ __('invoices.salary_for_period') }} ({{ $timesheets->sum('quantity') }} {{ __('timesheets.days') }})
                    @else
                        {{ __('invoices.purchase_invoice') }}
                    @endif
                </td>
                <td>{{ number_format($invoice->total_amount, 2) }} {{ $settings['currency'] ?? '€' }}</td>
            </tr>
            <tr class="total">
                <td></td>
                <td>{{ __('invoices.total') }}: {{ number_format($invoice->total_amount, 2) }} {{ $settings['currency'] ?? '€' }}</td>
            </tr>
        </table>

        @if($invoice->invoice_type == 'contact' && count($timesheets) > 0)
            <br><br>
            <h3>{{ __('invoices.breakdown') }}</h3>
            <table>
                <tr class="heading">
                    <td>{{ __('timesheets.date') }}</td>
                    <td>{{ __('timesheets.days') }}</td>
                    <td>{{ __('timesheets.comment') }}</td>
                </tr>
                @foreach($timesheets as $timesheet)
                    <tr class="item">
                        <td>{{ $timesheet->date->format('Y-m-d') }}</td>
                        <td>{{ $timesheet->quantity }}</td>
                        <td>{{ $timesheet->comment }}</td>
                    </tr>
                @endforeach
            </table>
        @endif
    </div>
</body>
</html>
