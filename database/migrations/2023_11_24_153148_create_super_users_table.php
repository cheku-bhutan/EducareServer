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
        Schema::create('super_users', function (Blueprint $table) {
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile_no')->unique();
            $table->string('password');
            $table->string('profile_picture')->nullable();
            $table->integer('logins')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->foreign('role')->references('id')->on('roles');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('super_users');
    }
};
