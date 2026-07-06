@extends('layouts.adminlte')

@section('title', __('actions.add_new'))
@section('page-header', __('actions.add_new'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">{{ __('menu.dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">{{ __('menu.products') }}</a></li>
    <li class="breadcrumb-item active">{{ __('actions.add_new') }}</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('actions.add_new') }}</h3>
    </div>
    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="name">{{ __('products.name') }}</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="reference">{{ __('products.reference') }}</label>
                <input type="text" name="reference" id="reference" class="form-control @error('reference') is-invalid @enderror" value="{{ old('reference') }}" required>
                @error('reference') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="description">{{ __('products.description') }}</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                @error('description') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="unit_price">{{ __('products.unit_price') }}</label>
                <input type="number" step="0.01" name="unit_price" id="unit_price" class="form-control @error('unit_price') is-invalid @enderror" value="{{ old('unit_price') }}" required>
                @error('unit_price') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="alert_threshold">{{ __('products.alert_threshold') }}</label>
                <input type="number" name="alert_threshold" id="alert_threshold" class="form-control @error('alert_threshold') is-invalid @enderror" value="{{ old('alert_threshold', 5) }}" required>
                @error('alert_threshold') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">{{ __('actions.save') }}</button>
            <a href="{{ route('products.index') }}" class="btn btn-default">{{ __('actions.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
