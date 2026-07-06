@extends('layouts.adminlte')

@section('title', __('settings.title'))
@section('page-header', __('settings.title'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">{{ __('menu.dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ __('settings.title') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ __('settings.title') }}</h3>
            </div>
            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="company_name">{{ __('settings.company_name') }}</label>
                                <input type="text" name="company_name" id="company_name" class="form-control" value="{{ $settings['company_name'] ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="company_email">{{ __('settings.company_email') }}</label>
                                <input type="email" name="company_email" id="company_email" class="form-control" value="{{ $settings['company_email'] ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="company_phone">{{ __('settings.company_phone') }}</label>
                                <input type="text" name="company_phone" id="company_phone" class="form-control" value="{{ $settings['company_phone'] ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="company_address">{{ __('settings.company_address') }}</label>
                                <textarea name="company_address" id="company_address" class="form-control" rows="3">{{ $settings['company_address'] ?? '' }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="currency">{{ __('settings.currency') }}</label>
                                <input type="text" name="currency" id="currency" class="form-control" value="{{ $settings['currency'] ?? '€' }}">
                            </div>
                            <div class="form-group">
                                <label for="default_language">{{ __('settings.language') }}</label>
                                <select name="default_language" id="default_language" class="form-control">
                                    <option value="en" {{ ($settings['default_language'] ?? 'en') == 'en' ? 'selected' : '' }}>English</option>
                                    <option value="fr" {{ ($settings['default_language'] ?? 'en') == 'fr' ? 'selected' : '' }}>Français</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="working_days_per_month">{{ __('settings.working_days_per_month') }}</label>
                                <input type="number" name="working_days_per_month" id="working_days_per_month" class="form-control" value="{{ $settings['working_days_per_month'] ?? '22' }}" min="1" max="31">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{ __('actions.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
