@extends('layouts.adminlte')

@section('title', __('menu.contacts'))
@section('page-header', __('menu.contacts'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">{{ __('menu.dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ __('menu.contacts') }}</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('contacts.list') }}</h3>
        <div class="card-tools">
            <a href="{{ route('contacts.index', ['export' => 1]) }}" class="btn btn-success btn-sm">
                <i class="fas fa-file-export"></i> {{ __('actions.export') }}
            </a>
            <a href="{{ route('contacts.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> {{ __('actions.add_new') }}
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="mb-4">
            <form action="{{ route('contacts.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>{{ __('actions.search') }}</label>
                            <input type="text" name="search" class="form-control" placeholder="{{ __('actions.search') }}..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>{{ __('menu.contact_roles') }}</label>
                            <select name="role" class="form-control select2">
                                <option value="">{{ __('actions.all') }}</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>{{ __('contacts.hire_date') }} ({{ __('actions.from') }})</label>
                            <input type="date" name="hire_date_from" class="form-control" value="{{ request('hire_date_from') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>{{ __('contacts.hire_date') }} ({{ __('actions.to') }})</label>
                            <input type="date" name="hire_date_to" class="form-control" value="{{ request('hire_date_to') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>{{ __('contacts.managed_by') }}</label>
                            <select name="managed_by" class="form-control select2">
                                <option value="">{{ __('contacts.all_managers') }}</option>
                                @foreach($allContacts as $c)
                                    <option value="{{ $c->id }}" {{ request('managed_by') == $c->id ? 'selected' : '' }}>{{ $c->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> {{ __('actions.filter') }}
                                </button>
                                <a href="{{ route('contacts.index') }}" class="btn btn-default">
                                    <i class="fas fa-sync"></i> {{ __('actions.reset') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>{{ __('contacts.full_name') }}</th>
                        <th>{{ __('menu.contact_roles') }}</th>
                        <th>{{ __('contacts.email') }}</th>
                        <th>{{ __('contacts.phone') }}</th>
                        <th>{{ __('contacts.hire_date') }}</th>
                        <th>{{ __('contacts.salary') }}</th>
                        <th>{{ __('contacts.manager') }}</th>
                        <th width="150px">{{ __('actions.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contacts as $contact)
                    <tr>
                        <td>{{ $contact->id }}</td>
                        <td>{{ $contact->full_name }}</td>
                        <td>
                            @foreach($contact->roles as $role)
                                <span class="badge badge-info">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ $contact->phone }}</td>
                        <td>{{ $contact->hire_date->format('Y-m-d') }}</td>
                        <td>{{ number_format($contact->salary, 2) }} {{ $settings['currency'] ?? '€' }}</td>
                        <td>
                            @if($contact->manager)
                                <a href="{{ route('contacts.show', $contact->manager) }}">{{ $contact->manager->full_name }}</a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('contacts.show', $contact) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('actions.are_you_sure') }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">{{ __('contacts.no_contacts_found') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer clearfix">
        {{ $contacts->links() }}
    </div>
</div>
@endsection
