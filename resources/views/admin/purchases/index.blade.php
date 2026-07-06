@extends('layouts.adminlte')

@section('title', __('menu.purchases'))
@section('page-header', __('menu.purchases'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">{{ __('menu.dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ __('menu.purchases') }}</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('purchases.list') }}</h3>
        <div class="card-tools">
            <a href="{{ route('purchases.index', ['export' => 1]) }}" class="btn btn-success btn-sm">
                <i class="fas fa-file-export"></i> {{ __('actions.export') }}
            </a>
            <a href="{{ route('purchases.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> {{ __('actions.add_new') }}
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="mb-4">
            <form action="{{ route('purchases.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>{{ __('actions.search') }}</label>
                            <input type="text" name="search" class="form-control" placeholder="{{ __('actions.search') }}..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>{{ __('suppliers.list') }}</label>
                            <select name="supplier_id" class="form-control select2">
                                <option value="">{{ __('actions.all') }}</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>{{ __('purchases.date') }} ({{ __('actions.from') }})</label>
                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>{{ __('purchases.date') }} ({{ __('actions.to') }})</label>
                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> {{ __('actions.filter') }}
                                </button>
                                <a href="{{ route('purchases.index') }}" class="btn btn-default">
                                    <i class="fas fa-sync"></i> {{ __('actions.reset') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ __('purchases.date') }}</th>
                        <th>{{ __('purchases.invoice_number') }}</th>
                        <th>{{ __('purchases.supplier') }}</th>
                        <th>{{ __('purchases.product') }}</th>
                        <th>{{ __('purchases.quantity') }}</th>
                        <th>{{ __('purchases.price') }}</th>
                        <th>{{ __('purchases.total') }}</th>
                        <th>{{ __('actions.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchases as $purchase)
                    <tr>
                        <td>{{ $purchase->purchase_date->format('Y-m-d') }}</td>
                        <td><code>{{ $purchase->invoice_number }}</code></td>
                        <td>{{ $purchase->supplier->name }}</td>
                        <td>{{ $purchase->product->name }}</td>
                        <td>{{ $purchase->quantity }}</td>
                        <td>{{ number_format($purchase->purchase_price, 2) }} {{ $settings['currency'] ?? '€' }}</td>
                        <td>{{ number_format($purchase->total, 2) }} {{ $settings['currency'] ?? '€' }}</td>
                        <td>
                            <a href="{{ route('purchases.show', $purchase) }}" class="btn btn-info btn-sm" title="{{ __('actions.view') }}">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('purchases.pdf', $purchase) }}" class="btn btn-danger btn-sm" title="{{ __('actions.print_pdf') }}" target="_blank">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                            <a href="{{ route('purchases.edit', $purchase) }}" class="btn btn-warning btn-sm" title="{{ __('actions.edit') }}">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('purchases.destroy', $purchase) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('actions.are_you_sure') }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">{{ __('purchases.no_purchases_found') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer clearfix">
        {{ $purchases->links() }}
    </div>
</div>
@endsection
