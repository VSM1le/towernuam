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
            $table->foreign('inv_ps_group')->references('ps_group')->on('ps_groups');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice_headers', function (Blueprint $table) {
        $table->dropForeign('invoice_headers_inv_ps_group_foreign');
        });
    }
};
