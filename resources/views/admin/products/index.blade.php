@extends('layouts.adminlte')

@section('title', __('menu.products'))
@section('page-header', __('menu.products'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">{{ __('menu.dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ __('menu.products') }}</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('products.list') }}</h3>
        <div class="card-tools">
            <a href="{{ route('products.index', ['export' => 1]) }}" class="btn btn-success btn-sm">
                <i class="fas fa-file-export"></i> {{ __('actions.export') }}
            </a>
            <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> {{ __('actions.add_new') }}
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="mb-4">
            <form action="{{ route('products.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{ __('actions.search') }}</label>
                            <input type="text" name="search" class="form-control" placeholder="{{ __('actions.search') }}..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{ __('products.stock_quantity') }}</label>
                            <select name="filter" class="form-control">
                                <option value="">{{ __('actions.all') }}</option>
                                <option value="low_stock" {{ request('filter') == 'low_stock' ? 'selected' : '' }}>{{ __('dashboard.low_stock_products') }}</option>
                                <option value="out_of_stock" {{ request('filter') == 'out_of_stock' ? 'selected' : '' }}>{{ __('products.out_of_stock') ?? 'Out of stock' }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> {{ __('actions.filter') }}
                                </button>
                                <a href="{{ route('products.index') }}" class="btn btn-default">
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
                        <th>{{ __('products.reference') }}</th>
                        <th>{{ __('products.name') }}</th>
                        <th>{{ __('products.unit_price') }}</th>
                        <th>{{ __('products.current_stock') }}</th>
                        <th>{{ __('products.alert_threshold') }}</th>
                        <th>{{ __('actions.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td><code>{{ $product->reference }}</code></td>
                        <td>{{ $product->name }}</td>
                        <td>{{ number_format($product->unit_price, 2) }} {{ $settings['currency'] ?? '€' }}</td>
                        <td>
                            @if($product->current_stock <= $product->alert_threshold)
                                <span class="badge badge-danger">{{ $product->current_stock }}</span>
                            @else
                                <span class="badge badge-success">{{ $product->current_stock }}</span>
                            @endif
                        </td>
                        <td>{{ $product->alert_threshold }}</td>
                        <td>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
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
                        <td colspan="6" class="text-center">{{ __('products.no_products_found') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer clearfix">
        <div class="float-right">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
