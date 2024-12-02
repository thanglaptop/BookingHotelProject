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
        Schema::create('dondatphong', function (Blueprint $table) {
            $table->tinyInteger('ddp_id', true, true);
            $table->date('ddp_ngaydat');
            $table->string('ddp_customername', 30);
            $table->char('ddp_sdt', 10);
            $table->float('ddp_total')->unsigned();
            $table->enum('ddp_pttt',['tt','momo', 'bank']);
            $table->enum('ddp_status', ['pending', 'confirmed', 'checkedin', 'completed', 'canceled'])->default('pending');
            $table->tinyInteger('c_id')->unsigned()->nullable();
            $table->tinyInteger('h_id')->unsigned()->nullable();
            $table->foreign('c_id')->references('c_id')->on('customer')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('h_id')->references('h_id')->on('hotel')->onUpdate('cascade')->onDelete('cascade');
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dondatphong');
        Schema::table('dondatphong', function (Blueprint $table) {
            $table->dropForeign(['dondatphong_c_id_foreign', 'dondatphong_h_id_foreign']);
            $table->dropIndex(['dondatphong_c_id_foreign', 'dondatphong_h_id_foreign']);
        });
    }
};
