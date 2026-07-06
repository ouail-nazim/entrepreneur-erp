<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\TimesheetController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\ContactRoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\LocaleController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('lang/{locale}', [LocaleController::class, 'setLocale'])->name('locale.set');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::resource('contacts', ContactController::class);
    Route::get('contacts/{contact}/export-timesheets', [ContactController::class, 'exportTimesheets'])->name('contacts.export-timesheets');
    Route::post('contacts/{contact}/timesheet', [TimesheetController::class, 'store'])->name('contacts.timesheet.store');

    Route::get('timesheets', [TimesheetController::class, 'index'])->name('timesheets.index');
    Route::post('timesheets/{timesheet}/validate', [TimesheetController::class, 'validateTimesheet'])->name('timesheets.validate');
    Route::post('timesheets/{timesheet}/reject', [TimesheetController::class, 'rejectTimesheet'])->name('timesheets.reject');
    Route::delete('timesheets/{timesheet}', [TimesheetController::class, 'destroy'])->name('timesheets.destroy');

    Route::resource('products', ProductController::class);
    Route::post('products/{product}/use-stock', [ProductController::class, 'useStock'])->name('products.use-stock');
    Route::resource('suppliers', SupplierController::class);
    Route::resource('purchases', PurchaseController::class);
    Route::get('purchases/{purchase}/pdf', [PurchaseController::class, 'pdf'])->name('purchases.pdf');
    Route::resource('contact_roles', ContactRoleController::class);

    Route::resource('invoices', InvoiceController::class);
    Route::get('invoices/{invoice}/download', [InvoiceController::class, 'downloadPdf'])->name('invoices.download');

    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
});
