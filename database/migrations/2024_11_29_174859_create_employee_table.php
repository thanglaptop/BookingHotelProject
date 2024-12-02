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
        Schema::create('employee', function (Blueprint $table) {
            $table->tinyInteger('e_id', true, true);
            $table->char('e_username',15)->unique();
            $table->char('e_pass',60);
            $table->string('e_name', 30);
            $table->tinyInteger('o_id')->unsigned();
            $table->tinyInteger('h_id')->unsigned();
            $table->foreign('o_id')->references('o_id')->on('owner')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('h_id')->references('h_id')->on('hotel')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee');
        Schema::table('employee', function (Blueprint $table) {
            $table->dropForeign(['employee_o_id_foreign', 'employee_h_id_foreign']);
            $table->dropIndex(['employee_o_id_foreign', 'employee_h_id_foreign']);
        });
    }
};
