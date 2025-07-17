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
        Schema::create('productcategories', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('slug')->nullable();
            $table->string('name');
            $table->string('name_arabic')->nullable();
            $table->string('h1_en')->nullable();
            $table->string('h1_arabic')->nullable();
            $table->text('description')->nullable();
            $table->text('description_arabic')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_title_arabic')->nullable();
            $table->string('meta_canonical')->nullable();
            $table->string('meta_canonical_arabic')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_description_arabic')->nullable();
            $table->string('meta_tags')->nullable();
            $table->string('meta_tags_arabic')->nullable();
            $table->string('content_title')->nullable();
            $table->string('content_title_arabic')->nullable();
            $table->text('content_description')->nullable();
            $table->text('content_description_arabic')->nullable();
            $table->boolean('status')->nullable()->default(false);
            $table->boolean('not_for_export')->nullable()->default(false);
            $table->boolean('show_in_menu')->nullable()->default(false);
            $table->boolean('show_on_arabyads')->nullable()->default(false);
            $table->boolean('nofollow_analytics')->nullable()->default(false);
            $table->boolean('noindex_analytics')->nullable()->default(false);
            $table->string('redirection_link')->nullable();
            $table->string('sell_type', 100)->nullable();
            $table->string('value', 100)->nullable();
            $table->string('parent_category')->nullable();
            $table->string('icon')->nullable();
            $table->string('brand_link')->nullable();
            $table->string('image_link')->nullable();
            $table->string('website_image')->nullable();
            $table->string('mobile_image')->nullable();
            $table->integer('creator_id');
            $table->integer('sorting')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productcategories');
    }
};
