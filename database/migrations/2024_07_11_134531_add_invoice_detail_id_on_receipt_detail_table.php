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
        Schema::table('receip_details', function (Blueprint $table) {
            $table->foreignId('invoice_detail_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('receip_details', function (Blueprint $table) {
           $table->dropColumn('invoice_detail_id'); 
        });
    }
};