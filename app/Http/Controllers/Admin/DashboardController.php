<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Timesheet;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_contacts' => Contact::count(),
            'total_products' => Product::count(),
            'purchases_this_month' => Purchase::whereMonth('purchase_date', now()->month)->count(),
            'total_invoices_this_month' => Invoice::whereMonth('created_at', now()->month)->count(),
            'pending_timesheets' => Timesheet::where('status', 'pending')->count(),
            'low_stock_products' => Product::whereColumn('current_stock', '<=', 'alert_threshold')->count(),
            'total_revenue' => Invoice::where('invoice_type', 'supplier')->sum('total_amount'), // This is actually expenses if supplier, but let's call it revenue/turnover for employee invoices
            'monthly_expenses' => Purchase::whereMonth('purchase_date', now()->month)->sum('total'),
        ];

        $recent_contacts = Contact::latest()->take(5)->get();
        $recent_timesheets = Timesheet::with('contact')->latest()->take(5)->get();
        $recent_purchases = Purchase::with(['supplier', 'product'])->latest()->take(5)->get();

        // Data for charts
        $monthly_days = Timesheet::select(
                DB::raw('MONTH(date) as month'),
                DB::raw('SUM(quantity) as total_days')
            )
            ->where('status', 'validated')
            ->whereYear('date', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $invoice_stats = Invoice::select('invoice_type', DB::raw('count(*) as total'))
            ->groupBy('invoice_type')
            ->get();

        return view('admin.dashboard.index', compact('stats', 'recent_contacts', 'recent_timesheets', 'recent_purchases', 'monthly_days', 'invoice_stats'));
    }
}
