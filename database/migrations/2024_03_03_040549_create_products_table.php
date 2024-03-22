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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name' , 255);
            $table->enum('size',[0, 1 , 2 , 3 , 4, 5]);
            $table->string('photo');
            $table->string('total_amount');
            $table->float('price');
            $table->longText('prod_detail')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->unsignedBigInteger('color_id')->nullable();
            $table->foreign('type_id')->references('id')->on('types')->nullOnDelete();
            $table->foreign('color_id')->references( 'id')->on('colors')->nullOnDelete();
            $table->foreignId('store_id')->constrained('stores' , 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
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
