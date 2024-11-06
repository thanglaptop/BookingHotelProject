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
        Schema::create('hotel', function (Blueprint $table) {
            $table->tinyInteger('h_id', true, true);
            $table->string('h_name', 50);
            $table->string('h_dchi', 100);
            $table->char('h_sdt', 10);
            $table->string('h_mota', 255);
            $table->boolean('h_isclose')->default(false);
            $table->date('h_dateclose')->nullable();
            $table->date('h_dateopen')->nullable();
            $table->tinyInteger('o_id')->unsigned();
            $table->tinyInteger('lh_id')->unsigned();
            $table->tinyInteger('ct_id')->unsigned();
            $table->tinyInteger('pm_id')->unsigned();
            $table->foreign('o_id')->references('o_id')->on('owner')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('lh_id')->references('lh_id')->on('loaihinh')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('ct_id')->references('ct_id')->on('city')->onUpdate('cascade')->onDelete('cascade');
            $table->index('pm_id', 'hotel_pm_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel');
        
        Schema::table('hotel', function (Blueprint $table) {
            $table->dropForeign(['hotel_o_id_foreign', 'hotel_lh_id_foreign', 'hotel_ct_id_foreign']);
            $table->dropIndex(['hotel_o_id_foreign', 'hotel_lh_id_foreign', 'hotel_ct_id_foreign']);
        });
    }
};
