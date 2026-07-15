<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);

        // Default company settings
        \App\Models\Setting::set('app_name', 'Moustafa Marouf');
        \App\Models\Setting::set('company_name', 'Promotion Immobilière Moustafa Marouf');
        \App\Models\Setting::set('company_email', 'moustafamarouf24@gmail.com');
        \App\Models\Setting::set('company_phone', '+213 770753232');
        \App\Models\Setting::set('company_address', 'Cité 8 aout 1954, Ain Mkhlouf Guelma');
        \App\Models\Setting::set('currency', 'DA');
        \App\Models\Setting::set('default_language', 'fr');
        \App\Models\Setting::set('working_days_per_month', '22');

        // Admin user
        $admin = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'moustafamarouf24_admin@gmail.com',
            'password' => bcrypt('U*31xJ/65z+ln?v@va'),
        ]);
        $admin->assignRole('admin');

        // Manager user
        $manager = \App\Models\User::factory()->create([
            'name' => 'Manager',
            'email' => 'moustafamarouf24_manager@gmail.com',
            'password' => bcrypt('cKB6qh£4SGr2u{HPI-'),
        ]);
        $manager->assignRole('manager');

        // // Contacts (Employees)
        // $contacts = \App\Models\Contact::factory(13)->create();

        // // Suppliers
        // $suppliers = \App\Models\Supplier::factory(5)->create();

        // // Products
        // $products = \App\Models\Product::factory(15)->create();

        // // Purchases and Stock update
        // foreach ($products as $product) {
        //     $numPurchases = rand(1, 3);
        //     for ($i = 0; $i < $numPurchases; $i++) {
        //         $qty = rand(10, 50);
        //         $price = $product->unit_price * 0.8; // Purchase price lower than unit price

        //         \App\Models\Purchase::create([
        //             'supplier_id' => $suppliers->random()->id,
        //             'product_id' => $product->id,
        //             'purchase_date' => now()->subDays(rand(1, 60)),
        //             'quantity' => $qty,
        //             'purchase_price' => $price,
        //             'total' => $qty * $price,
        //             'invoice_number' => 'PUR-' . strtoupper(uniqid()),
        //         ]);

        //         // Note: The Purchase model has a booted method that updates product stock
        //     }
        // }

        // // Timesheets for the last 2 months
        // foreach ($contacts as $contact) {
        //     $startDate = now()->subMonths(2)->startOfMonth();
        //     $endDate = now();

        //     for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
        //         // Skip weekends (optional, but realistic)
        //         if ($date->isWeekend()) continue;

        //         // 90% chance of working
        //         if (rand(1, 100) > 90) continue;

        //         \App\Models\Timesheet::create([
        //             'contact_id' => $contact->id,
        //             'date' => $date->format('Y-m-d'),
        //             'quantity' => 1,
        //             'comment' => 'Regular working day',
        //             'status' => 'validated',
        //             'validated_by' => 1,
        //             'validated_at' => now(),
        //         ]);
        //     }
        // }

        // // Some pending timesheets for demonstration
        // foreach ($contacts->random(5) as $contact) {
        //     \App\Models\Timesheet::create([
        //         'contact_id' => $contact->id,
        //         'date' => now()->format('Y-m-d'),
        //         'quantity' => rand(1, 2) == 1 ? 1 : 0.5,
        //         'status' => 'pending',
        //     ]);
        // }

        // // Generate some fake invoices
        // foreach ($contacts as $contact) {
        //     // Invoice for last month
        //     $start = now()->subMonth()->startOfMonth();
        //     $end = now()->subMonth()->endOfMonth();

        //     $timesheets = \App\Models\Timesheet::where('contact_id', $contact->id)
        //         ->whereBetween('date', [$start->format('Y-m-d'), $end->format('Y-m-d')])
        //         ->where('status', 'validated')
        //         ->get();

        //     if ($timesheets->count() > 0) {
        //         $totalHours = $timesheets->sum('quantity');
        //         $totalAmount = $totalHours * $contact->hourly_rate;

        //         \App\Models\Invoice::create([
        //             'contact_id' => $contact->id,
        //             'invoice_type' => 'contact',
        //             'period_start' => $start,
        //             'period_end' => $end,
        //             'total_amount' => $totalAmount,
        //             'generated_by' => 1,
        //             'invoice_number' => 'INV-' . $start->format('Y') . '-' . str_pad($contact->id, 4, '0', STR_PAD_LEFT),
        //         ]);
        //     }
        // }
    }
}
