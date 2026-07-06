@extends('layouts.adminlte')

@section('title', __('actions.edit'))
@section('page-header', __('actions.edit'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('dashboard.title') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('contact_roles.index') }}">{{ __('menu.contact_roles') }}</a></li>
    <li class="breadcrumb-item active">{{ __('actions.edit') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">{{ __('actions.edit') }}</h3>
            </div>
            <form action="{{ route('contact_roles.update', $contactRole) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">{{ __('contact_roles.name') }}</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $contactRole->name) }}" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="slug">{{ __('contact_roles.slug') }}</label>
                        <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" id="slug" value="{{ old('slug', $contactRole->slug) }}" required>
                        @error('slug')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">{{ __('contact_roles.description') }}</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="3">{{ old('description', $contactRole->description) }}</textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">{{ __('actions.save') }}</button>
                    <a href="{{ route('contact_roles.index') }}" class="btn btn-default">{{ __('actions.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
