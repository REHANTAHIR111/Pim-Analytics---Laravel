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
            $table->integer('id', true);
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('phone_number', 20)->nullable();
            $table->string('email', 150)->unique('email');
            $table->timestamp('email_verified_at')->useCurrent();
            $table->date('date_of_birth')->nullable();
            $table->integer('gender')->nullable()->default(0);
            $table->string('password');
            $table->string('profile_image')->nullable();
            $table->rememberToken();
            $table->integer('creator_id');
            $table->integer('role')->nullable();
            $table->integer('status')->nullable()->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
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
