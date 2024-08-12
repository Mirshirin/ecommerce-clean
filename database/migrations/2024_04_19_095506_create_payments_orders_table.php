<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->decimal('amount_paid', 8, 2);
            $table->string('status')->default('pending'); // وضعیت پیش‌فرض "در انتظار"
            $table->string('transaction_id')->nullable(); // شناسه تراکنش برای سرویس‌های خارجی
            $table->string('reference_id')->nullable(); // شناسه مرجع برای سرویس‌های خارجی
            $table->timestamp('payment_date');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_orders');
    }
};
