<?php

use App\Models\InvoiceHeader;
use App\Services\numberToBath;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('invoice', 'invoicepdf.invoice1')
    ->middleware(['auth'])
    ->name('invoice');

// Route::view('invoice3', 'invoicepdf.invoice3')
//     ->middleware(['auth'])
//     ->name('invoice');


Route::get('invoice3', function () {
    $number = new numberToBath;
    $invoice = InvoiceHeader::where('id',16)->with(['invoicedetail','customerrental','customer'])->first();
    $bath = $number->baht_text($invoice->invoicedetail->sum('invd_net_amt'));

    return view('invoicepdf.invoice3', [
        'Invoices' => $invoice,
        'bath' => $bath,
    ]);
})->middleware(['auth'])->name('invoice');    

require __DIR__.'/auth.php';
