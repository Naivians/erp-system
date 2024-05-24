<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
<<<<<<< HEAD
        Schema::create('products', function (Blueprint $table) {
=======
        Schema::table('products', function (Blueprint $table) {
>>>>>>> 2dade71d450ca7c500175aa0a6d2d79fe5155b34
            $table->string('product_name');
            $table->string('category');
            $table->string('code');
            $table->string('description');
            $table->decimal('price', 10, 2);
            $table->string('icon')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
