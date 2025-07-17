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
        Schema::create('product_faqs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('title');
            $table->string('question_english');
            $table->string('question_arabic')->nullable();
            $table->text('answer_english');
            $table->text('answer_arabic')->nullable();
            $table->integer('creator_id');
            $table->integer('status');
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_faqs');
    }
};
