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
        Schema::create('comanda_products', function (Blueprint $table) {
            $table->integer('quantity');
            $table->decimal('individual_price', 10, 2);
            $table->boolean('is_paid')->default(false);
            $table->timestamps();

            $table->unsignedBigInteger('comanda_id');
            $table->unsignedBigInteger('product_id');

            $table->foreign('comanda_id')->references('id')->on('comandas');
            $table->foreign('product_id')->references('id')->on('products');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comandas_products');
    }
};
