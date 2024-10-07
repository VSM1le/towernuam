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
        Schema::table('creditnote_headers', function (Blueprint $table) {
            $table->char('credit_no',20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('creditnote_headers', function (Blueprint $table) {
            $table->dropColumn('credit_no'); 
        });
    }
};
