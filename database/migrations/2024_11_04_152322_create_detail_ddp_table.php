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
        Schema::create('detail_ddp', function (Blueprint $table) { 
            $table->tinyInteger('detail_id', true, true);
            $table->date('detail_checkin');
            $table->date('detail_checkout');
            $table->tinyInteger('detail_soluong')->unsigned();
            $table->float('detail_thanhtien')->unsigned();
            $table->tinyInteger('r_id')->unsigned();
            $table->tinyInteger('ddp_id')->unsigned();
            $table->foreign('r_id')->references('r_id')->on('room')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('ddp_id')->references('ddp_id')->on('dondatphong')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_ddp');
        Schema::table('detail_ddp', function (Blueprint $table) {
            $table->dropForeign(['detail_ddp_r_id_foreign', 'detail_ddp_ddp_id_foreign']);
            $table->dropIndex(['detail_ddp_r_id_foreign', 'detail_ddp_ddp_id_foreign']);
        });
    }
};
