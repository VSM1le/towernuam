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
        Schema::table('customer_rentals', function (Blueprint $table) {
            $table->foreign('cust_code')->references('cust_code')->on('customers'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_rentals', function (Blueprint $table) {
            $table->dropForeign('customer_rentals_cust_code_foreign');
        });
    }
};
