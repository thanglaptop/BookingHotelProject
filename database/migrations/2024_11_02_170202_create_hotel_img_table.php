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
        Schema::create('hotel_img', function (Blueprint $table) {
            $table->tinyInteger('h_id')->unsigned();
            $table->foreign('h_id')->references('h_id')->on('hotel')->onUpdate('cascade')->onDelete('cascade');
            $table->char('hi_name', 15);
            $table->tinyInteger('hi_vitri')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_img');
        Schema::table('hotel_img', function (Blueprint $table) {
            $table->dropForeign(['hotel_img_h_id_foreign']);
            $table->dropIndex(['hotel_img_h_id_foreign']);
        });
    }
};
