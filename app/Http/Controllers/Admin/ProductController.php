<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('export')) {
            return $this->export($request);
        }
        $query = Product::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('reference', 'like', "%{$search}%");
            });
        }

        if ($request->filter == 'low_stock') {
            $query->whereColumn('current_stock', '<=', 'alert_threshold');
        } elseif ($request->filter == 'out_of_stock') {
            $query->where('current_stock', '<=', 0);
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        return view('admin.products.index', compact('products'));
    }

    public function export(Request $request)
    {
        $products = Product::all();
        $csvFileName = 'products_' . date('Ymd_His') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Reference', 'Name', 'Price', 'Stock', 'Threshold'];

        $callback = function() use($products, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($products as $product) {
                $row['Reference'] = $product->reference;
                $row['Name']      = $product->name;
                $row['Price']     = $product->unit_price;
                $row['Stock']     = $product->current_stock;
                $row['Threshold'] = $product->alert_threshold;

                fputcsv($file, array_values($row));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'reference' => 'required|string|unique:products,reference',
            'description' => 'nullable|string',
            'unit_price' => 'required|numeric|min:0',
            'alert_threshold' => 'required|integer|min:0',
        ]);

        Product::create($validated);
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        $product->load(['purchases.supplier', 'movements' => function($query) {
            $query->latest();
        }]);
        return view('admin.products.show', compact('product'));
    }

    public function useStock(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->current_stock,
            'description' => 'nullable|string|max:255',
        ]);

        $quantity = $request->quantity;

        $product->current_stock -= $quantity;
        $product->save();

        $product->movements()->create([
            'type' => 'out',
            'quantity' => $quantity,
            'reference_type' => 'Usage',
            'description' => $request->description ?: __('products.manual_usage'),
        ]);

        return redirect()->back()->with('success', __('products.stock_updated_successfully'));
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'reference' => 'required|string|unique:products,reference,' . $product->id,
            'description' => 'nullable|string',
            'unit_price' => 'required|numeric|min:0',
            'alert_threshold' => 'required|integer|min:0',
        ]);

        $product->update($validated);
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
