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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            //user  && product
            $table->string('name');
            $table->string('email');
            $table->string('phone_number');
            $table->text('address');
            $table->string('product_title');
            $table->unsignedBigInteger('price');
            $table->integer('quantity');
            $table->string('image');
            $table->unsignedBigInteger('product_id');            
            $table->unsignedBigInteger('user_id');                 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');            
 
            // payment/
            $table->string('payment_status')->nullable();
            $table->string('delivery_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
