@extends('layouts.adminlte')

@section('title', __('menu.contact_roles'))
@section('page-header', __('menu.contact_roles'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('dashboard.title') }}</a></li>
    <li class="breadcrumb-item active">{{ __('menu.contact_roles') }}</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('menu.contact_roles') }}</h3>
        <div class="card-tools">
            <a href="{{ route('contact_roles.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> {{ __('actions.add_new') }}
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>{{ __('contact_roles.name') }}</th>
                    <th>{{ __('contact_roles.slug') }}</th>
                    <th>{{ __('contact_roles.description') }}</th>
                    <th style="width: 150px">{{ __('actions.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td><code>{{ $role->slug }}</code></td>
                    <td>{{ $role->description }}</td>
                    <td>
                        <a href="{{ route('contact_roles.edit', $role) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('contact_roles.destroy', $role) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('actions.confirm_delete') }}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        <div class="float-right">
            {{ $roles->links() }}
        </div>
    </div>
</div>
@endsection
