<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->string('middleName')->nullable();
            $table->string('lastName');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('role'); // admin, treasurer, encoder
            $table->string('status')->default('Active');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
    }
};