@extends('layouts.adminlte')

@section('title', __('menu.timesheets'))
@section('page-header', __('menu.timesheets'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">{{ __('menu.dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ __('menu.timesheets') }}</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('timesheets.list') }}</h3>
    </div>
    <div class="card-body">
        <div class="mb-4">
            <form action="{{ route('timesheets.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>{{ __('actions.search') }}</label>
                            <input type="text" name="search" class="form-control" placeholder="{{ __('actions.search_employee') }}" value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>{{ __('timesheets.employee') }}</label>
                            <select name="contact_id" class="form-control select2">
                                <option value="">{{ __('actions.all') }}</option>
                                @foreach($contacts as $contact)
                                    <option value="{{ $contact->id }}" {{ request('contact_id') == $contact->id ? 'selected' : '' }}>{{ $contact->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>{{ __('timesheets.status') }}</label>
                            <select name="status" class="form-control">
                                <option value="">{{ __('actions.all_statuses') }}</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('timesheets.pending') }}</option>
                                <option value="validated" {{ request('status') == 'validated' ? 'selected' : '' }}>{{ __('timesheets.validated') }}</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>{{ __('timesheets.rejected') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>{{ __('timesheets.date') }} ({{ __('actions.from') }})</label>
                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>{{ __('timesheets.date') }} ({{ __('actions.to') }})</label>
                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @if(request()->anyFilled(['search', 'contact_id', 'status', 'date_from', 'date_to']))
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('timesheets.index') }}" class="btn btn-sm btn-default">
                            <i class="fas fa-sync"></i> {{ __('actions.reset') }}
                        </a>
                    </div>
                </div>
                @endif
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ __('timesheets.date') }}</th>
                        <th>{{ __('timesheets.employee') }}</th>
                        <th>{{ __('timesheets.days') }}</th>
                        <th>{{ __('timesheets.status') }}</th>
                        <th>{{ __('timesheets.comment') }}</th>
                        <th>{{ __('actions.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($timesheets as $timesheet)
                    <tr>
                        <td>{{ $timesheet->date->format('Y-m-d') }}</td>
                        <td>{{ $timesheet->contact->full_name }}</td>
                        <td>{{ $timesheet->quantity }}</td>
                        <td>
                            @if($timesheet->status == 'validated')
                                <span class="badge badge-success">{{ __('timesheets.validated') }}</span>
                            @elseif($timesheet->status == 'pending')
                                <span class="badge badge-warning">{{ __('timesheets.pending') }}</span>
                            @else
                                <span class="badge badge-danger">{{ __('timesheets.rejected') }}</span>
                            @endif
                        </td>
                        <td>{{ Str::limit($timesheet->comment, 30) }}</td>
                        <td>
                            @if($timesheet->status == 'pending')
                            <form action="{{ route('timesheets.validate', $timesheet) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm" title="{{ __('actions.validate') }}">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            <form action="{{ route('timesheets.reject', $timesheet) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm" title="{{ __('actions.reject') }}">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                            @endif
                            <form action="{{ route('timesheets.destroy', $timesheet) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-default btn-sm" onclick="return confirm('{{ __('actions.confirm_delete') }}')">
                                    <i class="fas fa-trash text-danger"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">{{ __('timesheets.no_timesheets_found') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer clearfix">
        <div class="float-right">
            {{ $timesheets->links() }}
        </div>
    </div>
</div>
@endsection
