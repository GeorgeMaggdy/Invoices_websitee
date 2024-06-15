<?php

use App\Http\Controllers\InoviceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ArchiveController;

use App\Http\Controllers\InovicesDetailsController;
use App\Http\Controllers\InovicesAttachmentsController;

use App\Models\Inovice;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::resource('inovices', InoviceController::class);
Route::resource('sections', SectionController::class);
Route::resource('products', ProductController::class);
Route::resource('InvoiceAttachments', InovicesAttachmentsController::class);

Route::resource('archive', ArchiveController::class);


Route::get('/{page}', 'App\Http\Controllers\AdminController@index');
Route::get('/section/{id}', [InoviceController::class, 'getProducts']);
Route::get('/InvoicesDetails/{id}', [InovicesDetailsController::class, 'edit']);
Route::get('/edit_invoice/{id}', [InoviceController::class, 'show']);

Route::get('View_file/{invoice_number}/{file_name}', [InovicesDetailsController::class, 'open_file']);
Route::get('download/{invoice_number}/{file_name}', [InovicesDetailsController::class, 'get_file']);

Route::post('delete_file', [InovicesDetailsController::class, 'destroy'])->name('delete_file');

Route::post('delete_invoice', [InoviceController::class, 'destroy'])->name('delete_invoice');

Route::post('archive_invoice', [InoviceController::class, 'archive'])->name('archive_invoice');

Route::get('/edit_status/{id}', [InoviceController::class, 'display'])->name('edit_status');

Route::get('/print_bill/{id}', [InoviceController::class, 'read'])->name('print_bill');



Route::post('/update_status/{id}', [InoviceController::class, 'updateStatus'])->name('update_status');



Route::get('Paid_Bill', [InoviceController::class, 'Paid_Bill']);
Route::get('/Unpaid_bill', [InoviceController::class, 'Unpaid_bill']);
Route::get('/partially_paid', [InoviceController::class, 'partially_paid']);


Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});


//Route::resource('invoices',InoviceController::class);
