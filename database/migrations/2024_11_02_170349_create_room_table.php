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
        Schema::create('room', function (Blueprint $table) {
            $table->tinyInteger('r_id', true, true);
            $table->string('r_name', 50);
            $table->float('r_price')->unsigned();
            $table->tinyInteger('r_soluong', false, true);
            $table->string('r_mota', 400);
            $table->tinyInteger('r_maxadult')->unsigned();
            $table->tinyInteger('r_maxkid')->unsigned();
            $table->tinyInteger('r_maxperson')->unsigned();
            $table->tinyInteger('r_dientich')->unsigned();
            $table->tinyInteger('h_id')->unsigned();
            $table->foreign('h_id')->references('h_id')->on('hotel')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room');
        Schema::table('room', function (Blueprint $table) {
            $table->dropForeign(['room_h_id_foreign']);
            $table->dropIndex(['room_h_id_foreign']);
        });
    }
};
