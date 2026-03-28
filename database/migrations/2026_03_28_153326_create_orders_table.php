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
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

      // customer + address
      $table->string('customer_name');
      $table->string('customer_phone');
      $table->string('address_line');
      $table->string('city')->nullable();
      $table->string('note')->nullable();

      // totals
      $table->decimal('subtotal', 10, 2);
      $table->decimal('shipping', 10, 2)->default(0);
      $table->decimal('total', 10, 2);

      // status & payment
      $table->string('status')->default('pending'); // pending, paid, shipped...
      $table->string('payment_method')->default('cod'); // cod, qr
      $table->string('payment_status')->default('unpaid'); // unpaid, paid
      $table->string('payment_ref')->nullable(); // transaction id (optional)
      $table->string('receipt_image')->nullable(); // upload filename (optional)


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
