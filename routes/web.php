<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PurchaseReportController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\PurchaseRangeReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BackupController;

// ✅ NUEVOS CONTROLADORES PRO (los crearemos luego)
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;

Route::get('/', function () {
    return "🔥 Sistema de Inventario y Facturación - Farmacia Silva funcionando correctamente";
})->name('home');


/*
|--------------------------------------------------------------------------
| ✅ ÁREA PROTEGIDA (PRO)
|--------------------------------------------------------------------------
| Si tu login ya existe: dejá middleware('auth')
| Si NO tenés login todavía: quitá ->middleware(['auth'])
*/
//Route::middleware(['auth'])->group(function () {
Route::middleware([])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | ✅ CORE (CRUDs PRO)
    |--------------------------------------------------------------------------
    */
    Route::prefix('core')->name('core.')->group(function () {
        // Clientes
        Route::resource('customers', CustomerController::class);

        // Productos
        Route::resource('products', ProductController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | ✅ VENTAS (PRO)
    |--------------------------------------------------------------------------
    */
    Route::prefix('sales')->name('sales.')->group(function () {

        // Listado / crear / guardar / ver / eliminar
        Route::get('/', [SaleController::class, 'index'])->name('index');
        Route::get('/create', [SaleController::class, 'create'])->name('create');
        Route::post('/', [SaleController::class, 'store'])->name('store');
        Route::get('/{sale}', [SaleController::class, 'show'])->whereNumber('sale')->name('show');
        Route::delete('/{sale}', [SaleController::class, 'destroy'])->whereNumber('sale')->name('destroy');

        // Acceso directo a factura de la venta
        Route::get('/{sale}/invoice', [SaleController::class, 'invoice'])
            ->whereNumber('sale')
            ->name('invoice');
    });


    /*
    |--------------------------------------------------------------------------
    | ✅ FACTURAS (VENTAS) EXISTENTE
    |--------------------------------------------------------------------------
    */
    Route::get('/invoices/{sale}', [InvoiceController::class, 'show'])
        ->whereNumber('sale')
        ->name('invoices.show');

    Route::get('/invoices/{sale}/pdf', [InvoiceController::class, 'pdf'])
        ->whereNumber('sale')
        ->name('invoices.pdf');


    /*
    |--------------------------------------------------------------------------
    | ✅ COMPRAS (REPORTE) EXISTENTE
    |--------------------------------------------------------------------------
    */
    Route::get('/purchases/{purchase}', [PurchaseReportController::class, 'show'])
        ->whereNumber('purchase')
        ->name('purchases.show');


    /*
    |--------------------------------------------------------------------------
    | ✅ REPORTES EXISTENTE
    |--------------------------------------------------------------------------
    */
    Route::get('/reports/sales', [SalesReportController::class, 'index'])
        ->name('reports.sales');

    Route::get('/reports/sales/export', [SalesReportController::class, 'export'])
        ->name('reports.sales.export');

    Route::get('/reports/purchases', [PurchaseRangeReportController::class, 'index'])
        ->name('reports.purchases');

    Route::get('/reports/purchases/export', [PurchaseRangeReportController::class, 'export'])
        ->name('reports.purchases.export');


    /*
    |--------------------------------------------------------------------------
    | ✅ DASHBOARD EXISTENTE
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | ✅ BACKUP / RESTORE EXISTENTE
    |--------------------------------------------------------------------------
    */
    Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
    Route::post('/backup/create', [BackupController::class, 'create'])->name('backup.create');
    Route::get('/backup/download', [BackupController::class, 'download'])->name('backup.download');
    Route::post('/backup/restore', [BackupController::class, 'restore'])->name('backup.restore');
    Route::post('/backup/delete', [BackupController::class, 'delete'])->name('backup.delete');
});
