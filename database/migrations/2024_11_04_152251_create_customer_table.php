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
        Schema::create('customer', function (Blueprint $table) {
            $table->tinyInteger('c_id', true, true);
            $table->char('c_username',30)->unique();
            $table->char('c_pass',60);
            $table->string('c_name', 30);
            $table->char('c_sdt', 10);
            $table->date('c_nsinh');
            $table->char('c_email',30)->unique();
            $table->char('c_avatar',15)->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer');
    }
};
