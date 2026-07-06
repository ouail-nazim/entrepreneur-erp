@extends('layouts.adminlte')

@section('title', __('contacts.details'))

@section('page-header', __('contacts.details'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('menu.dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('contacts.index') }}">{{ __('menu.contacts') }}</a></li>
    <li class="breadcrumb-item active">{{ $contact->full_name }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-3">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    @if($contact->photo)
                        <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/' . $contact->photo) }}" alt="User profile picture">
                    @else
                        <img class="profile-user-img img-fluid img-circle" src="https://ui-avatars.com/api/?name={{ urlencode($contact->full_name) }}" alt="User profile picture">
                    @endif
                </div>

                <h3 class="profile-username text-center">{{ $contact->full_name }}</h3>
                <p class="text-muted text-center">{{ $contact->email }}</p>

                <div class="text-center mb-3">
                    @foreach($contact->roles as $role)
                        <span class="badge badge-info">{{ $role->name }}</span>
                    @endforeach
                </div>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>{{ __('contacts.phone') }}</b> <a class="float-right">{{ $contact->phone }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>{{ __('contacts.hire_date') }}</b> <a class="float-right">{{ $contact->hire_date->format('Y-m-d') }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>{{ __('contacts.salary') }}</b> <a class="float-right">{{ number_format($contact->salary, 2) }} {{ $settings['currency'] ?? '€' }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>{{ __('contacts.daily_rate') }}</b> <a class="float-right">{{ number_format($contact->daily_rate, 2) }} {{ $settings['currency'] ?? '€' }}</a>
                    </li>
                </ul>

                <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-warning btn-block"><b>{{ __('actions.edit') }}</b></a>
                <button onclick="window.print()" class="btn btn-default btn-block"><b><i class="fas fa-print"></i> {{ __('actions.print') }}</b></button>
            </div>
        </div>

        <!-- About Me Box -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ __('contacts.about_me') }}</h3>
            </div>
            <div class="card-body">
                <strong><i class="fas fa-map-marker-alt mr-1"></i> {{ __('contacts.address') }}</strong>
                <p class="text-muted">{{ $contact->address ?? 'N/A' }}</p>
                <hr>
                <strong><i class="fas fa-id-card mr-1"></i> {{ __('contacts.nin') }}</strong>
                <p class="text-muted">{{ $contact->nin ?? 'N/A' }}</p>
                <hr>
                <strong><i class="fas fa-file-medical mr-1"></i> {{ __('contacts.insurance_number') }}</strong>
                <p class="text-muted">{{ $contact->insurance_number ?? 'N/A' }}</p>
                <hr>
                <strong><i class="fas fa-user-tie mr-1"></i> {{ __('contacts.managed_by') }}</strong>
                <p class="text-muted">
                    @if($contact->manager)
                        <a href="{{ route('contacts.show', $contact->manager) }}">{{ $contact->manager->full_name }}</a>
                    @else
                        {{ __('contacts.no_manager') }}
                    @endif
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#timesheets" data-toggle="tab">{{ __('contacts.timesheets') }}</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="timesheets">
                        <div class="mb-3 d-flex justify-content-between align-items-center">
                             <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-add-timesheet">
                                 <i class="fas fa-plus"></i> {{ __('timesheets.add') }}
                             </button>
                             <a href="{{ route('invoices.create', ['contact_id' => $contact->id]) }}" class="btn btn-success">
                                 <i class="fas fa-file-invoice"></i> {{ __('invoices.generate_for_contact') }}
                             </a>
                             <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-export-timesheets">
                                 <i class="fas fa-file-excel"></i> {{ __('contacts.export_timesheets') }}
                             </button>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('timesheets.date') }}</th>
                                    <th>{{ __('timesheets.days') }}</th>
                                    <th>{{ __('timesheets.status') }}</th>
                                    <th>{{ __('timesheets.comment') }}</th>
                                    <th>{{ __('actions.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($contact->timesheets()->latest('date')->take(60)->get() as $timesheet)
                                    <tr>
                                        <td>{{ $timesheet->date->format('Y-m-d') }}</td>
                                        <td>{{ $timesheet->quantity }}</td>
                                        <td>
                                            @if($timesheet->status == 'pending')
                                                <span class="badge badge-warning">{{ __('timesheets.pending') }}</span>
                                            @elseif($timesheet->status == 'validated')
                                                <span class="badge badge-success">{{ __('timesheets.validated') }}</span>
                                            @else
                                                <span class="badge badge-danger">{{ __('timesheets.rejected') }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $timesheet->comment }}</td>
                                        <td>
                                            @if($timesheet->status == 'pending')
                                                <form action="{{ route('timesheets.validate', $timesheet) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm" title="{{ __('actions.validate') }}"><i class="fas fa-check"></i></button>
                                                </form>
                                                <form action="{{ route('timesheets.reject', $timesheet) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm" title="{{ __('actions.reject') }}"><i class="fas fa-times"></i></button>
                                                </form>
                                            @endif
                                            <form action="{{ route('timesheets.destroy', $timesheet) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-default btn-sm" onclick="return confirm('{{ __('actions.confirm_delete') }}')" title="{{ __('actions.delete') }}"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">{{ __('timesheets.no_records') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Export Timesheets -->
<div class="modal fade" id="modal-export-timesheets">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('contacts.export_timesheets') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('contacts.export-timesheets', $contact) }}" method="GET">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="start_date">{{ __('actions.start_date') }}</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ date('Y-m-01') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">{{ __('actions.end_date') }}</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ date('Y-m-t') }}" required>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('actions.close') }}</button>
                    <button type="submit" class="btn btn-info">{{ __('actions.export') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Add Timesheet -->
<div class="modal fade" id="modal-add-timesheet">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('timesheets.add') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('contacts.timesheet.store', $contact) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="date">{{ __('timesheets.date') }}</label>
                        <input type="date" name="date" id="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="quantity">{{ __('timesheets.days') }}</label>
                        <input type="number" step="0.5" name="quantity" id="quantity" class="form-control" placeholder="e.g. 1 or 0.5" required>
                    </div>
                    <div class="form-group">
                        <label for="comment">{{ __('timesheets.comment') }}</label>
                        <textarea name="comment" id="comment" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('actions.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('actions.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
