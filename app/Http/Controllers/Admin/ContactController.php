<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use App\Models\ContactRole;
use App\Services\ContactService;
use App\Exports\TimesheetExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function index(Request $request)
    {
        if ($request->has('export')) {
            return $this->export($request);
        }
        $contacts = $this->contactService->getAllContacts(10, $request->only('search', 'role', 'hire_date_from', 'hire_date_to', 'managed_by'));
        $roles = ContactRole::all();
        $allContacts = Contact::orderBy('first_name')->get();
        return view('admin.contacts.index', compact('contacts', 'roles', 'allContacts'));
    }

    public function export(Request $request)
    {
        $contacts = Contact::all();
        $csvFileName = 'contacts_' . date('Ymd_His') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['First Name', 'Last Name', 'Email', 'Phone', 'Hire Date', 'Salary'];

        $callback = function() use($contacts, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($contacts as $contact) {
                $row['First Name'] = $contact->first_name;
                $row['Last Name']  = $contact->last_name;
                $row['Email']      = $contact->email;
                $row['Phone']      = $contact->phone;
                $row['Hire Date']  = $contact->hire_date->format('Y-m-d');
                $row['Salary']     = $contact->salary;

                fputcsv($file, array_values($row));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function create()
    {
        $roles = ContactRole::all();
        $contacts = Contact::orderBy('first_name')->get();
        return view('admin.contacts.create', compact('roles', 'contacts'));
    }

    public function store(StoreContactRequest $request)
    {
        $this->contactService->createContact($request->validated());
        return redirect()->route('contacts.index')->with('success', __('contacts.created'));
    }

    public function show(Contact $contact)
    {
        $contact->load('timesheets', 'manager');
        return view('admin.contacts.show', compact('contact'));
    }

    public function exportTimesheets(Request $request, Contact $contact)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $fileName = 'timesheets_' . $contact->first_name . '_' . $contact->last_name . '_' . $request->start_date . '_to_' . $request->end_date . '.xlsx';

        return Excel::download(new TimesheetExport($contact->id, $request->start_date, $request->end_date), $fileName);
    }

    public function edit(Contact $contact)
    {
        $roles = ContactRole::all();
        $contacts = Contact::where('id', '!=', $contact->id)->orderBy('first_name')->get();
        return view('admin.contacts.edit', compact('contact', 'roles', 'contacts'));
    }

    public function update(UpdateContactRequest $request, Contact $contact)
    {
        $this->contactService->updateContact($contact, $request->validated());
        return redirect()->route('contacts.index')->with('success', __('contacts.updated'));
    }

    public function destroy(Contact $contact)
    {
        $this->contactService->deleteContact($contact);
        return redirect()->route('contacts.index')->with('success', __('contacts.deleted'));
    }
}
