@extends('layouts.adminlte')

@section('title', __('actions.edit'))

@section('page-header', __('actions.edit'))

@push('styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #007bff;
            border-color: #006fe6;
            color: #fff;
            padding: 0 10px;
            margin-top: .3rem;
        }
        .select2-container .select2-selection--multiple {
            min-height: 38px;
        }
    </style>
@endpush

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('menu.dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('contacts.index') }}">{{ __('menu.contacts') }}</a></li>
    <li class="breadcrumb-item active">{{ __('actions.edit') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">{{ __('actions.details') }}</h3>
            </div>
            <form action="{{ route('contacts.update', $contact) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name">{{ __('contacts.first_name') }}</label>
                                <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" id="first_name" value="{{ old('first_name', $contact->first_name) }}" required>
                                @error('first_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name">{{ __('contacts.last_name') }}</label>
                                <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" id="last_name" value="{{ old('last_name', $contact->last_name) }}" required>
                                @error('last_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">{{ __('contacts.email') }}</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email', $contact->email) }}" required>
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">{{ __('contacts.phone') }}</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" value="{{ old('phone', $contact->phone) }}" required>
                                @error('phone')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address">{{ __('contacts.address') }}</label>
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="address" rows="3">{{ old('address', $contact->address) }}</textarea>
                        @error('address')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nin">{{ __('contacts.nin') }}</label>
                                <input type="text" name="nin" class="form-control @error('nin') is-invalid @enderror" id="nin" value="{{ old('nin', $contact->nin) }}">
                                @error('nin')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="insurance_number">{{ __('contacts.insurance_number') }}</label>
                                <input type="text" name="insurance_number" class="form-control @error('insurance_number') is-invalid @enderror" id="insurance_number" value="{{ old('insurance_number', $contact->insurance_number) }}">
                                @error('insurance_number')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hire_date">{{ __('contacts.hire_date') }}</label>
                                <input type="date" name="hire_date" class="form-control @error('hire_date') is-invalid @enderror" id="hire_date" value="{{ old('hire_date', $contact->hire_date->format('Y-m-d')) }}" required>
                                @error('hire_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="salary">{{ __('contacts.salary') }}</label>
                                        <input type="number" step="0.01" name="salary" class="form-control @error('salary') is-invalid @enderror" id="salary" value="{{ old('salary', $contact->salary) }}" required>
                                        @error('salary')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="roles">{{ __('menu.contact_roles') }}</label>
                                        <select name="roles[]" id="roles" class="form-control select2 @error('roles') is-invalid @enderror" multiple="multiple" data-placeholder="{{ __('actions.select') }}">
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}" {{ (is_array(old('roles', $contact->roles->pluck('id')->toArray())) && in_array($role->id, old('roles', $contact->roles->pluck('id')->toArray()))) ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('roles')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="managed_by">{{ __('contacts.managed_by') }}</label>
                        <select name="managed_by" id="managed_by" class="form-control select2-single @error('managed_by') is-invalid @enderror">
                            <option value="">{{ __('contacts.no_manager') }}</option>
                            @foreach($contacts as $c)
                                <option value="{{ $c->id }}" {{ old('managed_by', $contact->managed_by) == $c->id ? 'selected' : '' }}>
                                    {{ $c->full_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('managed_by')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="photo">{{ __('contacts.photo') }}</label>
                        @if($contact->photo)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $contact->photo) }}" alt="Photo" class="img-thumbnail" style="height: 100px;">
                            </div>
                        @endif
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="photo" class="custom-file-input @error('photo') is-invalid @enderror" id="photo">
                                <label class="custom-file-label" for="photo">{{ __('actions.select_option') }}</label>
                            </div>
                        </div>
                        @error('photo')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">{{ __('actions.save') }}</button>
                    <a href="{{ route('contacts.index') }}" class="btn btn-default">{{ __('actions.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'default'
            });
            $('.select2-single').select2({
                theme: 'default',
                allowClear: true,
                placeholder: '{{ __('contacts.no_manager') }}'
            });

            // Handle custom file input
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
        });
    </script>
@endpush
