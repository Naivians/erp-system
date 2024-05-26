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
        Schema::create('wastes', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('category')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->float('price')->default(0);
            $table->float('beg_inv')->default(0);
            $table->float('initial')->default(0);
            $table->float('stockin')->default(0);
            $table->float('stockout')->default(0);
            $table->float('end_inv')->default(0);
            $table->float('total_amount')->default(0);
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wastes');
    }
};
