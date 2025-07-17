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
        Schema::create('sub_tags', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('tag_id');
            $table->string('name')->nullable();
            $table->string('name_ar')->nullable();
            $table->integer('sorting')->nullable()->default(0);
            $table->text('icon')->nullable();
            $table->text('image_link_app')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('sub_tags');
    }
};
