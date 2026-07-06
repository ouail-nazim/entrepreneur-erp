@extends('layouts.adminlte')

@section('title', __('products.details'))
@section('page-header', __('products.details'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">{{ __('menu.dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">{{ __('menu.products') }}</a></li>
    <li class="breadcrumb-item active">{{ __('products.details') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <h3 class="profile-username text-center">{{ $product->name }}</h3>
                <p class="text-muted text-center">{{ $product->reference }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>{{ __('products.unit_price') }}</b> <a class="float-right">{{ number_format($product->unit_price, 2) }} {{ $settings['currency'] ?? '€' }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>{{ __('products.current_stock') }}</b>
                        <a class="float-right">
                            @if($product->current_stock <= $product->alert_threshold)
                                <span class="badge badge-danger">{{ $product->current_stock }}</span>
                            @else
                                <span class="badge badge-success">{{ $product->current_stock }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="list-group-item">
                        <b>{{ __('products.alert_threshold') }}</b> <a class="float-right">{{ $product->alert_threshold }}</a>
                    </li>
                </ul>

                <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-block"><b>{{ __('actions.edit') }}</b></a>

                <hr>

                <a href="{{ route('purchases.create', ['product_id' => $product->id]) }}" class="btn btn-success btn-block">
                    <i class="fas fa-plus mr-1"></i> {{ __('products.add_purchase') }}
                </a>

                <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#useStockModal">
                    <i class="fas fa-minus mr-1"></i> {{ __('products.use_stock') }}
                </button>
            </div>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ __('products.description') }}</h3>
            </div>
            <div class="card-body">
                <p class="text-muted">{{ $product->description ?: __('products.no_description') }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="productTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="movements-tab" data-toggle="pill" href="#movements" role="tab" aria-controls="movements" aria-selected="true">{{ __('products.movement_history') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="purchases-tab" data-toggle="pill" href="#purchases" role="tab" aria-controls="purchases" aria-selected="false">{{ __('products.purchase_history') }}</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="productTabContent">
                    <div class="tab-pane fade show active" id="movements" role="tabpanel" aria-labelledby="movements-tab">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('products.date') }}</th>
                                        <th>{{ __('products.type') }}</th>
                                        <th>{{ __('products.quantity') }}</th>
                                        <th>{{ __('products.reference') }}</th>
                                        <th>{{ __('products.description') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($product->movements as $movement)
                                    <tr>
                                        <td>{{ $movement->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            @if($movement->type == 'in')
                                                <span class="badge badge-success">{{ __('products.stock_in') }}</span>
                                            @else
                                                <span class="badge badge-danger">{{ __('products.stock_out') }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $movement->quantity }}</td>
                                        <td>{{ $movement->reference_type }}</td>
                                        <td>{{ $movement->description }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">{{ __('products.no_movements_recorded') }}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="purchases" role="tabpanel" aria-labelledby="purchases-tab">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('purchases.date') }}</th>
                                        <th>{{ __('purchases.supplier') }}</th>
                                        <th>{{ __('purchases.quantity') }}</th>
                                        <th>{{ __('purchases.price') }}</th>
                                        <th>{{ __('purchases.total') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($product->purchases as $purchase)
                                    <tr>
                                        <td>{{ $purchase->purchase_date->format('Y-m-d') }}</td>
                                        <td>{{ $purchase->supplier->name }}</td>
                                        <td>{{ $purchase->quantity }}</td>
                                        <td>{{ number_format($purchase->purchase_price, 2) }} {{ $settings['currency'] ?? '€' }}</td>
                                        <td>{{ number_format($purchase->total, 2) }} {{ $settings['currency'] ?? '€' }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">{{ __('products.no_purchases_recorded') }}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Use Stock Modal -->
<div class="modal fade" id="useStockModal" tabindex="-1" role="dialog" aria-labelledby="useStockModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="useStockModalLabel">{{ __('products.use_stock') }} - {{ $product->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('products.use-stock', $product) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>{{ __('products.available_stock') }}: <strong>{{ $product->current_stock }}</strong></p>
                    <div class="form-group">
                        <label for="quantity">{{ __('products.quantity_to_use') }}</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" min="1" max="{{ $product->current_stock }}" required>
                    </div>
                    <div class="form-group">
                        <label for="description">{{ __('products.description') }} ({{ __('actions.optional') }})</label>
                        <textarea name="description" id="description" class="form-control" rows="2" placeholder="{{ __('products.manual_usage') }}"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('actions.cancel') }}</button>
                    <button type="submit" class="btn btn-danger">{{ __('products.confirm_use') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
