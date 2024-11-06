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
        Schema::create('room_tiennghi', function (Blueprint $table) {
            $table->tinyInteger('R_ID')->unsigned();
            $table->tinyInteger('TN_ID')->unsigned();
            $table->foreign('R_ID')->references('r_id')->on('room')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('TN_ID')->references('tn_id')->on('tiennghi')->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['R_ID', 'TN_ID']);
            $table->index('R_ID', 'room_tiennghi_r_id_foreign'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_tiennghi');
        Schema::table('room_tiennghi', function (Blueprint $table) {
            $table->dropForeign(['room_tiennghi_r_id_foreign', 'room_tiennghi_tn_id_foreign']);
            $table->dropIndex(['room_tiennghi_r_id_foreign', 'room_tiennghi_tn_id_foreign']);
        });
    }
};
