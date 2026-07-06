<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Invoice;
use App\Models\Purchase;
use App\Models\Timesheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with(['contact', 'supplier', 'generator']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('contact', function($cq) use ($search) {
                      $cq->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('supplier', function($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('type')) {
            $query->where('invoice_type', $request->type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $invoices = $query->latest()->paginate(10)->withQueryString();
        return view('admin.invoices.index', compact('invoices'));
    }

    public function create(Request $request)
    {
        $contacts = Contact::all();
        $selected_contact_id = $request->query('contact_id');
        return view('admin.invoices.create', compact('contacts', 'selected_contact_id'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'period_start' => 'required|date',
            'period_end' => 'required|date|after_or_equal:period_start',
        ]);

        $contact = Contact::findOrFail($validated['contact_id']);

        $timesheets = Timesheet::where('contact_id', $contact->id)
            ->whereBetween('date', [$validated['period_start'], $validated['period_end']])
            ->where('status', 'validated')
            ->get();

        $totalDays = $timesheets->sum('quantity');
        $totalAmount = $totalDays * $contact->daily_rate;

        $invoice = Invoice::create([
            'contact_id' => $contact->id,
            'invoice_type' => 'contact',
            'period_start' => $validated['period_start'],
            'period_end' => $validated['period_end'],
            'total_amount' => $totalAmount,
            'generated_by' => Auth::id(),
            'invoice_number' => 'INV-' . date('Y') . '-' . str_pad(Invoice::count() + 1, 4, '0', STR_PAD_LEFT),
        ]);

        return redirect()->route('invoices.show', $invoice)->with('success', 'Invoice generated successfully.');
    }

    public function show(Invoice $invoice)
    {
        return view('admin.invoices.show', compact('invoice'));
    }

    public function downloadPdf(Invoice $invoice)
    {
        $data = ['invoice' => $invoice];

        if ($invoice->invoice_type == 'contact') {
            $data['timesheets'] = Timesheet::where('contact_id', $invoice->contact_id)
                ->whereBetween('date', [$invoice->period_start, $invoice->period_end])
                ->where('status', 'validated')
                ->get();
        }

        $pdf = Pdf::loadView('admin.invoices.pdf', $data);
        return $pdf->download($invoice->invoice_number . '.pdf');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted.');
    }
}
