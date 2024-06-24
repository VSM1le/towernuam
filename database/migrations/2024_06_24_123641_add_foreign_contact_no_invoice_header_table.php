<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('invoice_headers', function (Blueprint $table) {
            $table->foreign('contact_no')->references('custr_no')->on('customer_rentals');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice_headers', function (Blueprint $table) {
            $table->dropForeign('invoice_headers_contact_no_foreign');
        });
    }
};
