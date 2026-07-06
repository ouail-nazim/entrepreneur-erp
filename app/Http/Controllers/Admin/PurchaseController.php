<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Setting;
use App\Models\Supplier;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('export')) {
            return $this->export($request);
        }
        $query = Purchase::with(['supplier', 'product']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('supplier', function($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('product', function($pq) use ($search) {
                      $pq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('purchase_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('purchase_date', '<=', $request->date_to);
        }

        $purchases = $query->latest()->paginate(10)->withQueryString();
        $suppliers = Supplier::all();
        return view('admin.purchases.index', compact('purchases', 'suppliers'));
    }

    public function export(Request $request)
    {
        $purchases = Purchase::with(['supplier', 'product'])->get();
        $csvFileName = 'purchases_' . date('Ymd_His') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Date', 'Invoice #', 'Supplier', 'Product', 'Quantity', 'Price', 'Total'];

        $callback = function() use($purchases, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($purchases as $purchase) {
                $row['Date']      = $purchase->purchase_date->format('Y-m-d');
                $row['Invoice #'] = $purchase->invoice_number;
                $row['Supplier']  = $purchase->supplier->name;
                $row['Product']   = $purchase->product->name;
                $row['Quantity']  = $purchase->quantity;
                $row['Price']     = $purchase->purchase_price;
                $row['Total']     = $purchase->total;

                fputcsv($file, array_values($row));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function create(Request $request)
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        $selected_product_id = $request->query('product_id');
        return view('admin.purchases.create', compact('suppliers', 'products', 'selected_product_id'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_id' => 'required|exists:products,id',
            'purchase_date' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'purchase_price' => 'required|numeric|min:0',
            'invoice_number' => 'required|string|unique:purchases,invoice_number',
        ]);

        $validated['total'] = $validated['quantity'] * $validated['purchase_price'];

        Purchase::create($validated);
        return redirect()->route('purchases.index')->with('success', 'Purchase recorded successfully.');
    }

    public function show(Purchase $purchase)
    {
        return view('admin.purchases.show', compact('purchase'));
    }

    public function edit(Purchase $purchase)
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('admin.purchases.edit', compact('purchase', 'suppliers', 'products'));
    }

    public function update(Request $request, Purchase $purchase)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_id' => 'required|exists:products,id',
            'purchase_date' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'purchase_price' => 'required|numeric|min:0',
            'invoice_number' => 'required|string|unique:purchases,invoice_number,' . $purchase->id,
        ]);

        $validated['total'] = $validated['quantity'] * $validated['purchase_price'];

        // Note: Manual stock adjustment might be needed if quantity changed
        // For simplicity, we assume purchases are mostly static or corrected via new purchases/adjustments

        $purchase->update($validated);
        return redirect()->route('purchases.index')->with('success', 'Purchase updated successfully.');
    }

    public function pdf(Purchase $purchase)
    {
        $purchase->load(['supplier', 'product']);
        $settings = [
            'company_name' => Setting::get('company_name', config('app.name')),
            'company_address' => Setting::get('company_address', ''),
            'company_phone' => Setting::get('company_phone', ''),
            'company_email' => Setting::get('company_email', ''),
            'currency' => Setting::get('currency', '€'),
        ];
        $currency = $settings['currency'];

        $pdf = Pdf::loadView('admin.purchases.pdf', compact('purchase', 'settings', 'currency'));

        return $pdf->download('purchase_' . $purchase->invoice_number . '.pdf');
    }

    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return redirect()->route('purchases.index')->with('success', 'Purchase deleted successfully.');
    }
}
