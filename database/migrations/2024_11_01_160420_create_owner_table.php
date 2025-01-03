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
        Schema::create('owner', function (Blueprint $table) {
            $table->tinyInteger('o_id', true, true);
            $table->char('o_username',15)->unique();
            $table->char('o_pass',60);
            $table->string('o_name', 30);
            $table->char('o_sdt', 10);
            $table->string('o_dchi', 100);
            $table->date('o_nsinh');
            $table->string('o_email', 30);
            $table->char('o_cccd', 12);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owner');
    }
};
