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
        Schema::create('product', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->string('name_arabic');
            $table->text('short_description')->nullable();
            $table->text('short_description_arabic')->nullable();
            $table->text('product_description')->nullable();
            $table->text('product_description_arabic')->nullable();
            $table->string('pormotion')->nullable();
            $table->string('pormotion_arabic')->nullable();
            $table->string('pormotion_color')->nullable();
            $table->string('badge_left')->nullable();
            $table->string('badge_left_arabic')->nullable();
            $table->string('badge_left_color')->nullable();
            $table->string('badge_right')->nullable();
            $table->string('badge_right_arabic')->nullable();
            $table->string('badge_right_color')->nullable();
            $table->string('slug')->nullable();
            $table->integer('regular_price')->nullable();
            $table->integer('sale_price');
            $table->integer('sorting')->nullable();
            $table->integer('bundle_price')->nullable();
            $table->integer('promo_price')->nullable();
            $table->string('promo_title')->nullable();
            $table->string('promo_title_arabic')->nullable();
            $table->text('notes')->nullable();
            $table->string('sku')->nullable();
            $table->string('mpn_flix_media')->nullable();
            $table->string('mpn_flix_media_english')->nullable();
            $table->string('mpn_flix_media_arabic')->nullable();
            $table->string('ln_sku')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('amazon_stock')->nullable();
            $table->boolean('ln_check_quantity')->nullable();
            $table->string('type', 11)->nullable();
            $table->string('custom_badge')->nullable();
            $table->string('custom_badge_arabic')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_title_arabic')->nullable();
            $table->string('meta_tags')->nullable();
            $table->string('meta_tags_arabic')->nullable();
            $table->string('meta_canonical')->nullable();
            $table->string('meta_canonical_arabic')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_description_arabic')->nullable();
            $table->boolean('status')->nullable();
            $table->boolean('enable_pre_order')->nullable();
            $table->boolean('not_fetch_order')->nullable();
            $table->boolean('vat_on_us')->nullable();
            $table->string('brand')->nullable();
            $table->string('warranty')->nullable();
            $table->boolean('best_selling_product')->nullable();
            $table->boolean('free_gift_product')->nullable();
            $table->boolean('low_in_stock')->nullable();
            $table->boolean('top_selling')->nullable();
            $table->boolean('installation')->nullable();
            $table->boolean('is_bundle')->nullable();
            $table->boolean('product_installation')->nullable();
            $table->boolean('allow_goole_merchant')->nullable();
            $table->string('product_featured_image')->nullable();
            $table->string('upload_featured_image')->nullable();
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
        Schema::dropIfExists('product');
    }
};
