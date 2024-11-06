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
        Schema::create('giohang', function (Blueprint $table) {
            $table->tinyInteger('C_ID')->unsigned();
            $table->tinyInteger('R_ID')->unsigned();
            $table->date('g_checkin');
            $table->date('g_checkout');
            $table->tinyInteger('g_soluong')->unsigned();
            $table->foreign('C_ID')->references('c_id')->on('customer')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('R_ID')->references('r_id')->on('room')->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['C_ID', 'R_ID']);
            $table->index('C_ID', 'giohang_c_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('giohang');
        Schema::table('giohang', function (Blueprint $table) {
            $table->dropForeign(['giohang_c_id_foreign', 'giohang_r_id_foreign']);
            $table->dropIndex(['giohang_c_id_foreign', 'giohang_r_id_foreign']);
        });
    }
};
