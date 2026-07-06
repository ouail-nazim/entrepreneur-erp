@extends('layouts.adminlte')

@section('title', __('menu.suppliers'))
@section('page-header', __('menu.suppliers'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">{{ __('menu.dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ __('menu.suppliers') }}</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('suppliers.list') }}</h3>
        <div class="card-tools">
            <a href="{{ route('suppliers.index', ['export' => 1]) }}" class="btn btn-success btn-sm">
                <i class="fas fa-file-export"></i> {{ __('actions.export') }}
            </a>
            <a href="{{ route('suppliers.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> {{ __('suppliers.add_new') }}
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('suppliers.index') }}" method="GET" class="mb-3">
            <div class="input-group input-group-sm" style="width: 300px;">
                <input type="text" name="search" class="form-control float-right" placeholder="{{ __('actions.search') }}..." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                    </button>
                    @if(request('search'))
                        <a href="{{ route('suppliers.index') }}" class="btn btn-default">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>{{ __('suppliers.name') }}</th>
                        <th>{{ __('suppliers.contact_name') }}</th>
                        <th>{{ __('suppliers.email') }}</th>
                        <th>{{ __('suppliers.phone') }}</th>
                        <th>{{ __('actions.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $supplier)
                    <tr>
                        <td>{{ $supplier->id }}</td>
                        <td>{{ $supplier->name }}</td>
                        <td>{{ $supplier->contact_name }}</td>
                        <td>{{ $supplier->email }}</td>
                        <td>{{ $supplier->phone }}</td>
                        <td>
                            <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('actions.are_you_sure') }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">{{ __('suppliers.no_suppliers_found') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer clearfix">
        <div class="float-right">
            {{ $suppliers->links() }}
        </div>
    </div>
</div>
@endsection
