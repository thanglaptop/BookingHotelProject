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
        Schema::create('hotel_tiennghi', function (Blueprint $table) {
            $table->tinyInteger('H_ID')->unsigned();
            $table->tinyInteger('TN_ID')->unsigned();
            $table->foreign('H_ID')->references('h_id')->on('hotel')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('TN_ID')->references('tn_id')->on('tiennghi')->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['H_ID', 'TN_ID']);
            $table->index('H_ID', 'hotel_tiennghi_h_id_foreign'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_tiennghi');
        Schema::table('hotel_tiennghi', function (Blueprint $table) {
            $table->dropForeign(['hotel_tiennghi_h_id_foreign', 'hotel_tiennghi_tn_id_foreign']);
            $table->dropIndex(['hotel_tiennghi_h_id_foreign', 'hotel_tiennghi_tn_id_foreign']);
        });
    }
};
