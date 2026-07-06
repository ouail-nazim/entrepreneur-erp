@extends('layouts.adminlte')

@section('title', __('menu.invoices'))
@section('page-header', __('menu.invoices'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">{{ __('menu.dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ __('menu.invoices') }}</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('invoices.list') }}</h3>
        <div class="card-tools">
            <a href="{{ route('invoices.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> {{ __('actions.add_new') }}
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="mb-4">
            <form action="{{ route('invoices.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>{{ __('actions.search') }}</label>
                            <input type="text" name="search" class="form-control" placeholder="{{ __('actions.search') }}..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>{{ __('invoices.type') }}</label>
                            <select name="type" class="form-control">
                                <option value="">{{ __('actions.all') }}</option>
                                <option value="contact" {{ request('type') == 'contact' ? 'selected' : '' }}>{{ __('invoices.employee_invoice') }}</option>
                                <option value="supplier" {{ request('type') == 'supplier' ? 'selected' : '' }}>{{ __('invoices.supplier_invoice') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>{{ __('invoices.date') }} ({{ __('actions.from') }})</label>
                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>{{ __('invoices.date') }} ({{ __('actions.to') }})</label>
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
                                <a href="{{ route('invoices.index') }}" class="btn btn-default">
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
                        <th>{{ __('invoices.date') }}</th>
                        <th>{{ __('invoices.invoice_number') }}</th>
                        <th>{{ __('invoices.type') }}</th>
                        <th>{{ __('invoices.entity') }}</th>
                        <th>{{ __('invoices.total') }}</th>
                        <th>{{ __('actions.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->created_at->format('Y-m-d') }}</td>
                        <td><code>{{ $invoice->invoice_number }}</code></td>
                        <td>
                            @if($invoice->invoice_type == 'contact')
                                <span class="badge badge-info">{{ __('invoices.contact') }}</span>
                            @else
                                <span class="badge badge-primary">{{ __('invoices.supplier') }}</span>
                            @endif
                        </td>
                        <td>
                            @if($invoice->invoice_type == 'contact')
                                {{ $invoice->contact->full_name }}
                            @else
                                {{ $invoice->supplier->name }}
                            @endif
                        </td>
                        <td>{{ number_format($invoice->total_amount, 2) }} {{ $settings['currency'] ?? '€' }}</td>
                        <td>
                            <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('invoices.download', $invoice) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                            <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="d-inline">
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
                        <td colspan="6" class="text-center">{{ __('invoices.no_invoices_found') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer clearfix">
        <div class="float-right">
            {{ $invoices->links() }}
        </div>
    </div>
</div>
@endsection
