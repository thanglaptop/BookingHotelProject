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
        Schema::create('payment_info', function (Blueprint $table) {
            $table->tinyInteger('pm_id', true, true);
            $table->string('pm_name', 50);
            $table->boolean('pm_athotel')->default(false);
            $table->char('pm_momo', 15);
            $table->char('pm_bank', 15);
            $table->char('pm_QRmomo', 15);
            $table->char('pm_QRbank', 15);
            $table->string('pm_mota', 255);
            $table->tinyInteger('o_id')->unsigned();
            $table->foreign('o_id')->references('o_id')->on('owner')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_info');
        Schema::table('payment_info', function (Blueprint $table) {
            $table->dropForeign(['payment_info_o_id_foreign']);
            $table->dropIndex(['payment_info_o_id_foreign']);
        });
    }
};
