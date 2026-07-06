@extends('layouts.adminlte')

@section('title', __('actions.add_new'))

@section('page-header', __('actions.add_new'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('menu.dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('invoices.index') }}">{{ __('menu.invoices') }}</a></li>
    <li class="breadcrumb-item active">{{ __('actions.add_new') }}</li>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ __('invoices.select_employee_period') }}</h3>
    </div>
    <form action="{{ route('invoices.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="contact_id">{{ __('invoices.contact') }}</label>
                <select name="contact_id" id="contact_id" class="form-control @error('contact_id') is-invalid @enderror" required>
                    <option value="">{{ __('invoices.select_employee') }}</option>
                    @foreach($contacts as $contact)
                        <option value="{{ $contact->id }}" {{ (old('contact_id') == $contact->id || (isset($selected_contact_id) && $selected_contact_id == $contact->id)) ? 'selected' : '' }}>{{ $contact->full_name }}</option>
                    @endforeach
                </select>
                @error('contact_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="period_start">{{ __('invoices.period_start') }}</label>
                        <input type="date" name="period_start" id="period_start" class="form-control @error('period_start') is-invalid @enderror" value="{{ old('period_start', date('Y-m-01')) }}" required>
                        @error('period_start')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="period_end">{{ __('invoices.period_end') }}</label>
                        <input type="date" name="period_end" id="period_end" class="form-control @error('period_end') is-invalid @enderror" value="{{ old('period_end', date('Y-m-t')) }}" required>
                        @error('period_end')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <p class="text-muted small">{{ __('invoices.only_validated_hint') }}</p>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">{{ __('actions.add_new') }}</button>
            <a href="{{ route('invoices.index') }}" class="btn btn-default">{{ __('actions.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
