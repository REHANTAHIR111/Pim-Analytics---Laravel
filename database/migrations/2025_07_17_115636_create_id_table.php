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
        Schema::create('id', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->string('name_arabic');
            $table->string('heading', 200);
            $table->string('heading_arabic', 200);
            $table->text('description');
            $table->text('description_arabic');
            $table->string('meta_title');
            $table->string('meta_title_arabic');
            $table->string('meta_tags');
            $table->string('meta_tags_arabic');
            $table->string('meta_canonical');
            $table->string('meta_canonical_arabic');
            $table->text('meta_description');
            $table->text('meta_description_arabic');
            $table->string('content_title');
            $table->string('content_title_arabic');
            $table->text('content_description');
            $table->text('content_description_arabic');
            $table->integer('status');
            $table->integer('not_for_export');
            $table->integer('show_in_menu');
            $table->integer('show_on_arabyads');
            $table->integer('no_follow');
            $table->integer('no_index');
            $table->string('redirection_link', 200);
            $table->string('sale_type', 20);
            $table->string('value');
            $table->integer('parent_id');
            $table->string('icon');
            $table->string('brand_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('id');
    }
};
