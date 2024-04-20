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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 128);
            $table->string('surname', 128);
            $table->string('patronymic', 128)->nullable();
            $table->string('login', 128)->unique();
            $table->string('password', 255);
            $table->string('email', 128)->unique();
            $table->bigInteger('telephone')->unique();
            $table->string('api_token', 255)->nullable();
            $table->foreignId('role_id')->constrained('roles', 'id')->onUpdate('cascade');
            $table->foreignId('shift_id')->nullable()->constrained('roles', 'id')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
