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
        Schema::create('room_img', function (Blueprint $table) {
            $table->tinyInteger('r_id')->unsigned();
            $table->foreign('r_id')->references('r_id')->on('room')->onUpdate('cascade')->onDelete('cascade');
            $table->char('ri_name', 15);
            $table->tinyInteger('ri_vitri')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_img');
        Schema::table('room_img', function (Blueprint $table) {
            $table->dropForeign(['room_img_h_id_foreign']);
            $table->dropIndex(['room_img_h_id_foreign']);
        });
    }
};
