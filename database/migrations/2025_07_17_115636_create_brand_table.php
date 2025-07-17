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
        Schema::create('brand', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('slug');
            $table->integer('sorting');
            $table->string('name');
            $table->string('name_arabic');
            $table->text('description')->nullable();
            $table->text('description_arabic')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_title_arabic')->nullable();
            $table->string('meta_tags')->nullable();
            $table->string('meta_tags_arabic')->nullable();
            $table->string('h1_en')->nullable();
            $table->string('h1_arabic')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_description_arabic')->nullable();
            $table->string('content_title')->nullable();
            $table->string('content_description')->nullable();
            $table->string('content_title_arabic')->nullable();
            $table->string('content_description_arabic')->nullable();
            $table->integer('status');
            $table->integer('popular_brand');
            $table->integer('show_in_front');
            $table->string('mobile_image')->nullable();
            $table->string('website_image')->nullable();
            $table->integer('creator_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brand');
    }
};
