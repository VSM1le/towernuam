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
        $table->foreign('rec_no')
                  ->references('rec_no')
                  ->on('receipt_headers')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('receip_details', function (Blueprint $table) {
            $table->dropForeign('receip_details_rec_no_foreign');
        });
    }
};
