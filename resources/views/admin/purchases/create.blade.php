@extends('layouts.adminlte')

@section('title', __('actions.add_new'))

@section('page-header', __('actions.add_new'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('menu.dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('purchases.index') }}">{{ __('menu.purchases') }}</a></li>
    <li class="breadcrumb-item active">{{ __('actions.add_new') }}</li>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ __('actions.add_new') }}</h3>
    </div>
    <form action="{{ route('purchases.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="supplier_id">{{ __('purchases.supplier') }}</label>
                        <select name="supplier_id" id="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror" required>
                            <option value="">{{ __('actions.select_option') }}</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="product_id">{{ __('purchases.product') }}</label>
                        <select name="product_id" id="product_id" class="form-control @error('product_id') is-invalid @enderror" required>
                            <option value="">{{ __('actions.select_option') }}</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ (old('product_id') == $product->id || (isset($selected_product_id) && $selected_product_id == $product->id)) ? 'selected' : '' }}>{{ $product->name }} ({{ $product->reference }})</option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="purchase_date">{{ __('purchases.date') }}</label>
                        <input type="date" name="purchase_date" id="purchase_date" class="form-control @error('purchase_date') is-invalid @enderror" value="{{ old('purchase_date', date('Y-m-d')) }}" required>
                        @error('purchase_date')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="quantity">{{ __('purchases.quantity') }}</label>
                        <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}" required>
                        @error('quantity')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="purchase_price">{{ __('purchases.price') }}</label>
                        <input type="number" step="0.01" name="purchase_price" id="purchase_price" class="form-control @error('purchase_price') is-invalid @enderror" value="{{ old('purchase_price') }}" required>
                        @error('purchase_price')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="invoice_number">{{ __('purchases.invoice_number') }}</label>
                <input type="text" name="invoice_number" id="invoice_number" class="form-control @error('invoice_number') is-invalid @enderror" value="{{ old('invoice_number') }}" required>
                @error('invoice_number')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">{{ __('actions.save') }}</button>
            <a href="{{ route('purchases.index') }}" class="btn btn-default">{{ __('actions.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
