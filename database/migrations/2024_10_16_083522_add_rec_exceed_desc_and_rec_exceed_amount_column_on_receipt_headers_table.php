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
        Schema::table('receipt_headers', function (Blueprint $table) {
            $table->string('rec_exceed_desc')->nullable(); 
            $table->double('rec_exceed_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('receipt_headers', function (Blueprint $table) {
            $table->dropColumn('rec_exceed_desc');
            $table->dropColumn('rec_exceed_amount');
        });
    }
};
