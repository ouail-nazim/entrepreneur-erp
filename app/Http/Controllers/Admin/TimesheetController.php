<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTimesheetRequest;
use App\Models\Contact;
use App\Models\Timesheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimesheetController extends Controller
{
    public function index(Request $request)
    {
        $query = Timesheet::with('contact');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('contact', function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('contact_id')) {
            $query->where('contact_id', $request->contact_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        $timesheets = $query->latest()->paginate(20)->withQueryString();
        $contacts = Contact::all();
        return view('admin.timesheets.index', compact('timesheets', 'contacts'));
    }

    public function store(StoreTimesheetRequest $request, Contact $contact)
    {
        $contact->timesheets()->create($request->validated());
        return redirect()->back()->with('success', 'Timesheet added successfully.');
    }

    public function validateTimesheet(Timesheet $timesheet)
    {
        $timesheet->update([
            'status' => 'validated',
            'validated_by' => Auth::id(),
            'validated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Timesheet validated.');
    }

    public function rejectTimesheet(Timesheet $timesheet)
    {
        $timesheet->update([
            'status' => 'rejected',
            'validated_by' => Auth::id(),
            'validated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Timesheet rejected.');
    }

    public function destroy(Timesheet $timesheet)
    {
        $timesheet->delete();
        return redirect()->back()->with('success', 'Timesheet deleted.');
    }
}
