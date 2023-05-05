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
        Schema::create('cashregisters', function(Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->boolean('movement')->default(true);

            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();

            $table->unsignedBigInteger('purchase_id')->nullable();
            $table->unsignedInteger('comanda_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->foreign('purchase_id')->references('id')->on('purchases');
            $table->foreign('comanda_id')->references('id')->on('comandas');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
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
