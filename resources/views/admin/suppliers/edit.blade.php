@extends('layouts.adminlte')

@section('title', __('actions.edit'))
@section('page-header', __('actions.edit'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">{{ __('menu.dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('suppliers.index') }}">{{ __('menu.suppliers') }}</a></li>
    <li class="breadcrumb-item active">{{ __('actions.edit') }}</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('actions.edit') }}: {{ $supplier->name }}</h3>
    </div>
    <form action="{{ route('suppliers.update', $supplier) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="name">{{ __('suppliers.name') }}</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $supplier->name) }}" required>
                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="contact_name">{{ __('suppliers.contact_name') }}</label>
                <input type="text" name="contact_name" id="contact_name" class="form-control @error('contact_name') is-invalid @enderror" value="{{ old('contact_name', $supplier->contact_name) }}">
                @error('contact_name') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="email">{{ __('suppliers.email') }}</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $supplier->email) }}" required>
                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="phone">{{ __('suppliers.phone') }}</label>
                <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $supplier->phone) }}" required>
                @error('phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="address">{{ __('suppliers.address') }}</label>
                <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror">{{ old('address', $supplier->address) }}</textarea>
                @error('address') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">{{ __('actions.save') }}</button>
            <a href="{{ route('suppliers.index') }}" class="btn btn-default">{{ __('actions.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
