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
        Schema::create('temp_stockins', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('category')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->float('price')->default(0);
            $table->float('stocks')->default(0);
            $table->float('total_amount')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_stockins');
    }
};
