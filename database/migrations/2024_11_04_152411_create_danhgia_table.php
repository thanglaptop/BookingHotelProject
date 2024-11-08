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
        Schema::create('danhgia', function (Blueprint $table) {
            $table->tinyInteger('dg_id', true, true);
            $table->enum('dg_star', ['1sao', '2sao', '3sao', '4sao', '5sao']);
            $table->string('dg_nhanxet', 400);
            $table->date('dg_ngaydg');
            $table->tinyInteger('c_id')->unsigned();
            $table->tinyInteger('detail_id')->unsigned();
            $table->foreign('c_id')->references('c_id')->on('customer')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('detail_id')->references('detail_id')->on('detail_ddp')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('danhgia');
        Schema::table('danhgia', function (Blueprint $table) {
            $table->dropForeign(['danhgia_c_id_foreign', 'danhgia_detail_id_foreign']);
            $table->dropIndex(['danhgia_c_id_foreign', 'danhgia_detail_id_foreign']);
        });
    }
};
