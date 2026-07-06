@extends('layouts.adminlte')

@section('title', __('menu.contact_roles'))
@section('page-header', __('menu.contact_roles'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('dashboard.title') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('contact_roles.index') }}">{{ __('menu.contact_roles') }}</a></li>
    <li class="breadcrumb-item active">{{ $contactRole->name }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <h3 class="profile-username text-center">{{ $contactRole->name }}</h3>
                <p class="text-muted text-center"><code>{{ $contactRole->slug }}</code></p>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>{{ __('contact_roles.description') }}</b> <span class="float-right">{{ $contactRole->description }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>{{ __('menu.contacts') }}</b> <span class="float-right">{{ $contactRole->contacts->count() }}</span>
                    </li>
                </ul>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('contact_roles.edit', $contactRole) }}" class="btn btn-info btn-sm">
                        <i class="fas fa-edit"></i> {{ __('actions.edit') }}
                    </a>
                    <a href="{{ route('contact_roles.index') }}" class="btn btn-default btn-sm">
                        {{ __('actions.back') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
