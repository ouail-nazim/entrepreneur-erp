@extends('layouts.adminlte')

@section('title', __('purchases.list'))

@section('page-header', __('purchases.list'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('menu.dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('purchases.index') }}">{{ __('menu.purchases') }}</a></li>
    <li class="breadcrumb-item active">{{ __('purchases.invoice_number') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">{{ __('purchases.invoice_number') }}: {{ $purchase->invoice_number }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>{{ __('purchases.supplier') }}:</strong>
                        <p>{{ $purchase->supplier->name }}</p>

                        <strong>{{ __('purchases.product') }}:</strong>
                        <p>{{ $purchase->product->name }} ({{ $purchase->product->reference }})</p>
                    </div>
                    <div class="col-md-6">
                        <strong>{{ __('purchases.date') }}:</strong>
                        <p>{{ $purchase->purchase_date->format('Y-m-d') }}</p>

                        <strong>{{ __('purchases.total') }}:</strong>
                                                <p>{{ number_format($purchase->total, 2) }} {{ $settings['currency'] ?? '€' }}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <strong>{{ __('purchases.quantity') }}:</strong>
                        <p>{{ $purchase->quantity }}</p>
                    </div>
                    <div class="col-md-4">
                        <strong>{{ __('purchases.price') }}:</strong>
                                                <p>{{ number_format($purchase->purchase_price, 2) }} {{ $settings['currency'] ?? '€' }}</p>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('purchases.pdf', $purchase) }}" class="btn btn-danger" target="_blank">
                    <i class="fas fa-file-pdf"></i> {{ __('actions.print_pdf') }}
                </a>
                <a href="{{ route('purchases.edit', $purchase) }}" class="btn btn-warning">{{ __('actions.edit') }}</a>
                <a href="{{ route('purchases.index') }}" class="btn btn-default">{{ __('actions.back') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
