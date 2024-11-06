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
        Schema::create('tiennghi', function (Blueprint $table) {
            $table->tinyInteger('tn_id', true, true);
            $table->string('tn_name', 20);
            $table->boolean('tn_ofhotel')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tiennghi');
    }
};
