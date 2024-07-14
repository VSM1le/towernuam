<?php

use App\Models\InvoiceHeader;
use App\Models\ReceiptHeader;
use App\Services\numberToBath;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('',fn () =>to_route('dashboard'));

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('receipt', 'receipt')
    ->middleware(['auth', 'verified'])
    ->name('receipt');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('invoice', 'invoicepdf.invoice1')
    ->middleware(['auth'])
    ->name('invoice');

// Route::view('invoice3', 'invoicepdf.invoice3')
//     ->middleware(['auth'])
//     ->name('invoice');


Route::get('invoice3/{id}', function ($id) {
    $number = new numberToBath;
    $receipt= ReceiptHeader::where('id',$id)->with(['receiptdetail','customer'])->first();
   $bath = $number->baht_text(round($receipt->receiptdetail->pluck('invoicedetail.invd_net_amt')
                        ->sum(),2)); 

    $receiptDetails = $receipt->receiptdetail->map(function ($detail){
        $detail->calculated_vat = round(($detail->rec_pay * $detail->invoicedetail->invd_vat_percent) / 100,2);
        $detail->gross = round($detail->rec_pay - ($detail->rec_pay * $detail->invoicedetail->invd_vat_percent / 100),2);
        $detail->whtax = round(($detail->rec_pay * $detail->invoicedetail->invd_wh_tax_percent) / 100 , 2);
        return $detail;
    });
    return view('invoicepdf.invoice1', [
        'Receipt' => $receipt,
        'receiptdetails' => $receiptDetails,
        'bath' => $bath,
    ]);
})->middleware(['auth'])->name('invoice');    

require __DIR__.'/auth.php';
