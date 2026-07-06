@extends('layouts.adminlte')

@section('title', __('invoices.view_details'))

@section('page-header', __('invoices.invoice_number') . ' ' . $invoice->invoice_number)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('menu.dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('invoices.index') }}">{{ __('menu.invoices') }}</a></li>
    <li class="breadcrumb-item active">{{ $invoice->invoice_number }}</li>
@endsection

@section('content')
<div class="invoice p-3 mb-3">
    <!-- title row -->
    <div class="row">
        <div class="col-12">
            <h4>
                <i class="fas fa-globe"></i> {{ __('settings.app_name') }}
                <small class="float-right">{{ __('invoices.date') }}: {{ $invoice->created_at->format('Y-m-d') }}</small>
            </h4>
        </div>
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            {{ __('invoices.invoice_from') }}
            <address>
                <strong>{{ $settings['company_name'] ?? __('settings.app_name') }}</strong><br>
                {!! nl2br(e($settings['company_address'] ?? '')) !!}<br>
                {{ __('contacts.phone') }}: {{ $settings['company_phone'] ?? '' }}<br>
                {{ __('contacts.email') }}: {{ $settings['company_email'] ?? '' }}
            </address>
        </div>
        <div class="col-sm-4 invoice-col">
            {{ __('invoices.invoice_to') }}
            <address>
                @if($invoice->invoice_type == 'contact')
                    <strong>{{ $invoice->contact->full_name }}</strong><br>
                    {{ $invoice->contact->address }}<br>
                    Phone: {{ $invoice->contact->phone }}<br>
                    Email: {{ $invoice->contact->email }}
                @else
                    <strong>{{ $invoice->supplier->name }}</strong><br>
                    {{ $invoice->supplier->address }}<br>
                    Phone: {{ $invoice->supplier->phone }}<br>
                    Email: {{ $invoice->supplier->email }}
                @endif
            </address>
        </div>
        <div class="col-sm-4 invoice-col">
            <b>{{ __('invoices.invoice_number') }} {{ $invoice->invoice_number }}</b><br>
            <br>
            <b>{{ __('invoices.order_id') }}:</b> {{ $invoice->id }}<br>
            <b>{{ __('invoices.generated_by') }}:</b> {{ $invoice->generator->name }}
        </div>
    </div>

    <!-- Table row -->
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>{{ __('invoices.description') }}</th>
                    <th>{{ __('invoices.period_start') }} / {{ __('invoices.period_end') }}</th>
                    <th>{{ __('invoices.total') }} {{ __('timesheets.days') }}</th>
                    <th>{{ __('invoices.subtotal') }}</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        @if($invoice->invoice_type == 'contact')
                            {{ __('invoices.salary_for_period') }}
                        @else
                            {{ __('invoices.purchase_invoice') }}
                        @endif
                    </td>
                    <td>
                        @if($invoice->period_start)
                            {{ $invoice->period_start->format('Y-m-d') }} - {{ $invoice->period_end->format('Y-m-d') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($invoice->invoice_type == 'contact')
                            <!-- Calculate days -->
                            {{ \App\Models\Timesheet::where('contact_id', $invoice->contact_id)->whereBetween('date', [$invoice->period_start, $invoice->period_end])->where('status', 'validated')->sum('quantity') }} {{ __('timesheets.days') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ number_format($invoice->total_amount, 2) }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
        </div>
        <div class="col-6">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th style="width:50%">{{ __('invoices.subtotal') }}:</th>
                        <td>{{ number_format($invoice->total_amount, 2) }} {{ $settings['currency'] ?? '€' }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('invoices.tax') }} (0.0%):</th>
                        <td>0.00 {{ $settings['currency'] ?? '€' }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('invoices.total') }}:</th>
                        <td>{{ number_format($invoice->total_amount, 2) }} {{ $settings['currency'] ?? '€' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- this row will not appear when printing -->
    <div class="row no-print">
        <div class="col-12">
            <a href="{{ route('invoices.download', $invoice) }}" class="btn btn-primary float-right" style="margin-right: 5px;">
                <i class="fas fa-download"></i> {{ __('invoices.download_pdf') }}
            </a>
        </div>
    </div>
</div>
@endsection
