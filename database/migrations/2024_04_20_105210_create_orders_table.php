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
            $table->dateTime('date_order');
            $table->foreignId('payment_id')->constrained('payments', 'id')->onUpdate('cascade');
            $table->foreignId('user_id')->constrained('users', 'id')->onUpdate('cascade');
            $table->foreignId('employee_id')->constrained('users', 'id')->onUpdate('cascade');
            $table->foreignId('status_id')->constrained('status_orders', 'id')->onUpdate('cascade');
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