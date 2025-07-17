<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\PermissionHelper;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Faq;
use App\Models\Tag;
use App\Models\Brand;
use App\Models\Categories;
use App\Models\KeyFeature;
use App\Models\SpecificationHeading;
use App\Models\SpecificationValue;
use App\Models\UpsaleItems;
use App\Models\RelatedBrands;
use App\Models\RelatedCategories;
use App\Models\ProductCategories;
use App\Models\ProductFaq;
use App\Models\ProductTags;
use App\Models\ProductImageGallery;

class ProductController extends Controller
{
    public function index(){
        $permission = PermissionHelper::getPermissions('product');
        if (!$permission || (!$permission->view && !$permission->view_all)) {
            return redirect()->route('index');
        }

        $product = collect();
        if ($permission) {
            if ($permission->view_all) {
                $product = Product::with('categories')->orderByDesc('id')->get();;
            } elseif ($permission->view) {
                $product = Product::with('categories')->where('creator_id', auth()->id())->orderByDesc('id')->get();
            }
        }

        return view('pim.product.listing', compact('product', 'permission'));
    }

    public function create(Request $request) {
        $permission = PermissionHelper::getPermissions('product');
        $faq_permission = PermissionHelper::getPermissions('productFaqs');
        $tag_permission = PermissionHelper::getPermissions('tags');
        $brand_permission = PermissionHelper::getPermissions('brand');
        $cat_permission = PermissionHelper::getPermissions('categories');

        if (!$permission || !$permission->create) {
            return redirect()->route('index');
        }

        $upsaleOptions = collect();
        if($permission){
            if ($permission->view_all) {
                $upsaleOptions = Product::select('id', 'sku')->where('status', 1)->get();
            } elseif ($permission->view) {
                $upsaleOptions = Product::select('id', 'sku')->where('creator_id', auth()->id())->where('status', 1)->get();
            }
        }

        $brandOptions = collect();
        if($brand_permission){
            if ($brand_permission->view_all) {
                $brandOptions = Brand::select('id', 'name')->where('status', 1)->get();
            } elseif ($brand_permission->view) {
                $brandOptions = Brand::select('id', 'name')->where('creator_id', auth()->id())->where('status', 1)->get();
            }
        }

        $categoryOptions = collect();
        if($cat_permission){
            if ($cat_permission->view_all) {
                $categoryOptions = Categories::select('id', 'name')->where('status', 1)->get();
            } elseif ($cat_permission->view) {
                $categoryOptions = Categories::select('id', 'name')->where('creator_id', auth()->id())->where('status', 1)->get();
            }
        }

        $product_faqsOptions = collect();
        if($faq_permission){
            if ($faq_permission->view_all) {
                $product_faqsOptions = Faq::select('id', 'title')->where('status', 1)->get();
            } elseif ($faq_permission->view) {
                $product_faqsOptions = Faq::select('id', 'title')->where('creator_id', auth()->id())->where('status', 1)->get();
            }
        }

        $product_tagsOptions = collect();
        if($tag_permission){
            if ($tag_permission->view_all) {
                $product_tagsOptions = Tag::select('id', 'name')->where('status', 1)->get();
            } elseif ($tag_permission->view) {
                $product_tagsOptions = Tag::select('id', 'name')->where('creator_id', auth()->id())->where('status', 1)->get();
            }
        }

        return view('pim.product.add', compact('upsaleOptions', 'product_faqsOptions', 'brandOptions', 'product_tagsOptions', 'categoryOptions'));
    }

    public function store(Request $request) {
        $user = Auth::user();
        $request->validate([
            'productNameEn' => 'required|string|max:255',
            'productNameAr' => 'required|string|max:255',
            'regular_price' => 'required|integer|max:99999999999',
            'sorting' => 'required|integer|max:99999999999',
            'sku' => 'required|string|max:255',
        ], [
            'productNameEn.required' => 'Please fill Name - En.',
            'productNameAr.required' => 'Please fill Name - Ar.',
            'regular_price.required' => 'Please fill Price',
            'sorting.required' => 'Please fill Sorting',
            'sku.required' => 'Please fill Sku',
        ]);

        Product::create([
            'name' => $request->productNameEn,
            'name_arabic' => $request->productNameAr,
            'short_description' => $request->shortDescriptionEn,
            'short_description_arabic' => $request->shortDescriptionAr,
            'product_description' => $request->descriptionEn,
            'product_description_arabic' => $request->descriptionAr,
            'pormotion' => $request->promotion_en,
            'pormotion_arabic' => $request->promotion_ar,
            'pormotion_color' => $request->promotion_color,
            'badge_left' => $request->badge_left_en,
            'badge_left_arabic' => $request->badge_left_ar,
            'badge_left_color' => $request->badge_left_color,
            'badge_right' => $request->badge_right_en,
            'badge_right_arabic' => $request->badge_right_ar,
            'badge_right_color' => $request->badge_right_color,
            'slug' => basename($request->slug),
            'regular_price' => $request->regular_price,
            'sale_price' => $request->sale_price,
            'sorting' => $request->sorting,
            'bundle_price' => $request->bundle_price,
            'promo_price' => $request->promo_price,
            'promo_title' => $request->promo_title,
            'promo_title_arabic' => $request->promo_title_ar,
            'notes' => $request->notes,
            'sku' => $request->sku,
            'mpn_flix_media' => $request->mpn_flix_media,
            'mpn_flix_media_english' => $request->mpn_flix_media_en,
            'mpn_flix_media_arabic' => $request->mpn_flix_media_ar,
            'ln_sku' => $request->ln_sku,
            'quantity' => $request->quantity,
            'amazon_stock' => $request->amazon_stock,
            'ln_check_quantity' => $request->check_in_sku_qty ? 1 : 0,
            'type' => $request->type,
            'custom_badge' => $request->custom_badge_en,
            'custom_badge_arabic' => $request->custom_badge_ar,
            'meta_title' => $request->metatitle,
            'meta_title_arabic' => $request->metatitleAr,
            'meta_tags' => $request->metatags,
            'meta_tags_arabic' => $request->metatagsAr,
            'meta_canonical' => $request->meta_canonical,
            'meta_canonical_arabic' => $request->meta_canonicalAr,
            'meta_description' => $request->metadescription,
            'meta_description_arabic' => $request->metadescriptionAr,
            'status' => $request->status ? 1 : 0,
            'enable_pre_order' => $request->enable_pre_product ? 1 : 0,
            'not_fetch_order' => $request->not_fetch_order ? 1 : 0,
            'vat_on_us' => $request->vat_on_us ? 1 : 0,
            'brand' => $request->product_brands,
            'warranty' => $request->warranty,
            'best_selling_product' => $request->best_selling_product ? 1 : 0,
            'free_gift_product' => $request->free_gift_product ? 1 : 0,
            'low_in_stock' => $request->low_in_stock ? 1 : 0,
            'top_selling' => $request->top_selling ? 1 : 0,
            'installation' => $request->installation ? 1 : 0,
            'is_bundle' => $request->is_bundle ? 1 : 0,
            'product_installation' => $request->product_installation ? 1 : 0,
            'allow_goole_merchant' => $request->google_merchant ? 1 : 0,
            'product_featured_image' => $request->featured_image,
            'upload_featured_image' => $request->image_mobile,
            'creator_id' => $user->id,
        ]);

        $product = Product::latest('id')->first();

        if ($request->filled('features_json')) {
            $features = json_decode($request->features_json, true);
            foreach ($features as $feature) {

            if (
                !empty($feature['en']) ||
                !empty($feature['ar']) ||
                !empty($feature['image'])
            ) {
                KeyFeature::create([
                'feature' => $feature['en'] ?? '',
                'feature_arabic' => $feature['ar'] ?? '',
                'feature_image' => $feature['image'] ?? '',
                'product_id' => $product->id,
                ]);
            }
            }
        }

        $specGroups = json_decode($request->specifications_json, true);
        if (!empty($specGroups) && is_array($specGroups)) {
            foreach ($specGroups as $group) {
            if (empty($group['specs_heading']) && empty($group['specs_headingAr'])) {
                continue;
            }
            $heading = SpecificationHeading::create([
                'product_id' => $product->id,
                'specs_heading' => $group['specs_heading'] ?? '',
                'specs_heading_arabic' => $group['specs_headingAr'] ?? '',
            ]);

            if (!empty($group['specsList']) && is_array($group['specsList'])) {
                foreach ($group['specsList'] as $item) {
                // Skip if all fields are empty
                if (
                    empty($item['specs']) &&
                    empty($item['specsAr']) &&
                    empty($item['value']) &&
                    empty($item['valueAr'])
                ) {
                    continue;
                }
                SpecificationValue::create([
                    'product_id' => $product->id,
                    'specs_heading_id' => $heading->id,
                    'specs' => $item['specs'] ?? '',
                    'specs_arabic'   => $item['specsAr'] ?? '',
                    'value' => $item['value'] ?? '',
                    'value_arabic' => $item['valueAr'] ?? '',
                ]);
                }
            }
            }
        }

        if($request->upsale_items){
            foreach ($request->upsale_items as $upsale) {
                if (!empty($upsale)) {
                    UpsaleItems::create([
                        'items_id' => $upsale,
                        'product_id' => $product->id
                    ]);
                }
            }
        }

        if($request->brand){
            foreach ($request->brand as $related_brand) {
                RelatedBrands::create([
                    'brand_id' => $related_brand,
                    'product_id' => $product->id
                ]);
            }
        }

        if($request->category){
            foreach ($request->category as $related_category) {
                RelatedCategories::create([
                    'category_id' => $related_category,
                    'product_id' => $product->id
                ]);
            }
        }

        if($request->product_faqs){
            foreach ($request->product_faqs as $faqs) {
                ProductFaq::create([
                    'faq_id' => $faqs,
                    'product_id' => $product->id
                ]);
            }
        }

        if($request->product_tags){
            foreach ($request->product_tags as $tags) {
                ProductTags::create([
                    'tag_id' => $tags,
                    'product_id' => $product->id
                ]);
            }
        }

        if($request->product_categories){
            foreach ($request->product_categories as $categories) {
                ProductCategories::create([
                    'category_id' => $categories,
                    'product_id' => $product->id
                ]);
            }
        }

        $imageUrlsString = $request->input('image_website');
        $imageUrls = array_filter(array_map('trim', explode(',', $imageUrlsString)));
        foreach ($imageUrls as $url) {
            ProductImageGallery::create([
                'product_id' => $product->id,
                'image_url' => $url,
            ]);
        }

        if ($request->has('submit')) {
            return redirect()->route('pim.product.listing')->with('message', 'Product has beeen Created Successfully!');
        }

        if ($request->has('save')) {
            return redirect()->route('pim.product.edit', ['id' => $product->id])->with('message', 'Product has beeen Created Successfully!');
        }
    }

    public function edit($id) {
        $permission = PermissionHelper::getPermissions('product');
        $faq_permission = PermissionHelper::getPermissions('productFaqs');
        $tag_permission = PermissionHelper::getPermissions('tags');
        $brand_permission = PermissionHelper::getPermissions('brand');
        $cat_permission = PermissionHelper::getPermissions('categories');

        if (!$permission || !$permission->create) {
            return redirect()->route('index');
        }

         $product = Product::with([
            'keyFeatures',
            'specificationHeadings.specificationValues',
            'upsaleItems',
            'relatedBrands',
            'relatedCategories',
            'faqs',
            'tags',
            'categories',
            'galleryImages',
        ])->findOrFail($id);

        if ($old = old('features_json')) {
            $featuresToUse = json_decode($old, true);
        } else {
            $featuresToUse = $product->keyFeatures->map(function($kf) {
                return [
                    'en' => $kf->feature,
                    'ar' => $kf->feature_arabic,
                    'image' => $kf->feature_image,
                ];
            })->toArray();

            if (empty($featuresToUse)) {
                $featuresToUse = [['en' => '', 'ar' => '', 'image' => '']];
            }
        }

        if ($old = old('specifications_json')) {
            $specsToUse = json_decode($old, true);
        } else {
            $specsToUse = $product
                ->specificationHeadings
                ->map(function($sh) {
                    return [
                        'specs_heading' => $sh->specs_heading,
                        'specs_headingAr' => $sh->specs_heading_arabic,
                        'specsList' => $sh->specificationValues->map(function($sv) {
                            return [
                                'specs' => $sv->specs,
                                'specsAr' => $sv->specs_arabic,
                                'value' => $sv->value,
                                'valueAr' => $sv->value_arabic,
                            ];
                        })->toArray(),
                    ];
                })->toArray();

            if (empty($specsToUse)) {
                $specsToUse = [[
                    'specs_heading'   => '',
                    'specs_headingAr' => '',
                    'specsList'       => [
                        ['specs' => '', 'specsAr' => '', 'value' => '', 'valueAr' => '']
                    ],
                ]];
            }
        }

        $upsaleOptions = collect();
        if($permission){
            if ($permission->view_all) {
                $upsaleOptions = Product::select('id', 'sku')->where('id', '!=', $id)->where('status', 1)->get();
            } elseif ($permission->view) {
                $upsaleOptions = Product::select('id', 'sku')->where('id', '!=', $id)->where('creator_id', auth()->id())->where('status', 1)->get();
            }
        }
        $selectedUpsale = $product->upsaleItems->pluck('items_id')->toArray();

        $brandOptions = collect();
        if($brand_permission){
            if ($brand_permission->view_all) {
                $brandOptions = Brand::select('id', 'name')->where('status', 1)->get();
            } elseif ($brand_permission->view) {
                $brandOptions = Brand::select('id', 'name')->where('creator_id', auth()->id())->where('status', 1)->get();
            }
        }
        $selectedRelatedBrands = $product->relatedBrands->pluck('id')->toArray();

        $categoryOptions = collect();
        if($cat_permission){
            if ($cat_permission->view_all) {
                $categoryOptions = Categories::select('id', 'name')->where('status', 1)->get();
            } elseif ($cat_permission->view) {
                $categoryOptions = Categories::select('id', 'name')->where('creator_id', auth()->id())->where('status', 1)->get();
            }
        }
        $selectedRelatedCategories = $product->relatedCategories->pluck('id')->toArray();

        $product_faqsOptions = collect();
        if($faq_permission){
            if ($faq_permission->view_all) {
                $product_faqsOptions = Faq::select('id', 'title')->where('status', 1)->get();
            } elseif ($faq_permission->view) {
                $product_faqsOptions = Faq::select('id', 'title')->where('creator_id', auth()->id())->where('status', 1)->get();
            }
        }
        $selectedFaqs = $product->faqs->pluck('id')->toArray();

        $product_tagsOptions = collect();
        if($tag_permission){
            if ($tag_permission->view_all) {
                $product_tagsOptions = Tag::select('id', 'name')->where('status', 1)->get();
            } elseif ($tag_permission->view) {
                $product_tagsOptions = Tag::select('id', 'name')->where('creator_id', auth()->id())->where('status', 1)->get();
            }
        }
        $selectedTags = $product->tags->pluck('id')->toArray();

        $selectedCategories = $product->categories->pluck('id')->toArray();
        $galleryImages = $product->galleryImages->pluck('image_url')->toArray();

        return view('pim.product.edit', compact('product', 'featuresToUse', 'specsToUse', 'upsaleOptions', 'selectedUpsale', 'selectedRelatedBrands', 'selectedFaqs', 'selectedTags', 'selectedRelatedCategories', 'selectedCategories', 'galleryImages', 'product_faqsOptions', 'brandOptions', 'product_tagsOptions', 'categoryOptions'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'productNameEn' => 'required|string|max:255',
            'productNameAr' => 'required|string|max:255',
            'regular_price' => 'required|integer|max:99999999999',
            'sorting' => 'required|integer|max:99999999999',
            'sku' => 'required|string|max:255',
        ], [
            'productNameEn.required' => 'Please fill Name - En.',
            'productNameAr.required' => 'Please fill Name - Ar.',
            'regular_price.required' => 'Please fill Price',
            'sorting.required' => 'Please fill Sorting',
            'sku.required' => 'Please fill Sku',
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'name' => $request->productNameEn,
            'name_arabic' => $request->productNameAr,
            'short_description' => $request->shortDescriptionEn,
            'short_description_arabic' => $request->shortDescriptionAr,
            'product_description' => $request->descriptionEn,
            'product_description_arabic' => $request->descriptionAr,
            'pormotion' => $request->promotion_en,
            'pormotion_arabic' => $request->promotion_ar,
            'pormotion_color' => $request->promotion_color,
            'badge_left' => $request->badge_left_en,
            'badge_left_arabic' => $request->badge_left_ar,
            'badge_left_color' => $request->badge_left_color,
            'badge_right' => $request->badge_right_en,
            'badge_right_arabic' => $request->badge_right_ar,
            'badge_right_color' => $request->badge_right_color,
            'slug' => basename($request->slug),
            'regular_price' => $request->regular_price,
            'sale_price' => $request->sale_price,
            'sorting' => $request->sorting,
            'bundle_price' => $request->bundle_price,
            'promo_price' => $request->promo_price,
            'promo_title' => $request->promo_title,
            'promo_title_arabic' => $request->promo_title_ar,
            'notes' => $request->notes,
            'sku' => $request->sku,
            'mpn_flix_media' => $request->mpn_flix_media,
            'mpn_flix_media_english' => $request->mpn_flix_media_en,
            'mpn_flix_media_arabic' => $request->mpn_flix_media_ar,
            'ln_sku' => $request->ln_sku,
            'quantity' => $request->quantity,
            'amazon_stock' => $request->amazon_stock,
            'ln_check_quantity' => $request->check_in_sku_qty ? 1 : 0,
            'type' => $request->type,
            'custom_badge' => $request->custom_badge_en,
            'custom_badge_arabic' => $request->custom_badge_ar,
            'meta_title' => $request->metatitle,
            'meta_title_arabic' => $request->metatitleAr,
            'meta_tags' => $request->metatags,
            'meta_tags_arabic' => $request->metatagsAr,
            'meta_canonical' => $request->meta_canonical,
            'meta_canonical_arabic' => $request->meta_canonicalAr,
            'meta_description' => $request->metadescription,
            'meta_description_arabic' => $request->metadescriptionAr,
            'status' => $request->status ? 1 : 0,
            'enable_pre_order' => $request->enable_pre_product ? 1 : 0,
            'not_fetch_order' => $request->not_fetch_order ? 1 : 0,
            'vat_on_us' => $request->vat_on_us ? 1 : 0,
            'brand' => $request->product_brands,
            'warranty' => $request->warranty,
            'best_selling_product' => $request->best_selling_product ? 1 : 0,
            'free_gift_product' => $request->free_gift_product ? 1 : 0,
            'low_in_stock' => $request->low_in_stock ? 1 : 0,
            'top_selling' => $request->top_selling ? 1 : 0,
            'installation' => $request->installation ? 1 : 0,
            'is_bundle' => $request->is_bundle ? 1 : 0,
            'product_installation' => $request->product_installation ? 1 : 0,
            'allow_goole_merchant' => $request->google_merchant ? 1 : 0,
            'product_featured_image' => $request->featured_image,
            'upload_featured_image' => $request->image_mobile,
        ]);

        // Remove old features and add new ones
        KeyFeature::where('product_id', $product->id)->delete();
        if ($request->filled('features_json')) {
            $features = json_decode($request->features_json, true);
            foreach ($features as $feature) {
            if (
                !empty($feature['en']) ||
                !empty($feature['ar']) ||
                !empty($feature['image'])
            ) {
                KeyFeature::create([
                'feature' => $feature['en'] ?? '',
                'feature_arabic' => $feature['ar'] ?? '',
                'feature_image' => $feature['image'] ?? '',
                'product_id' => $product->id,
                ]);
            }
            }
        }

        // Remove old specification headings and values, then add new ones
        $headingIds = SpecificationHeading::where('product_id', $product->id)->pluck('id');
        SpecificationValue::whereIn('specs_heading_id', $headingIds)->delete();
        SpecificationHeading::where('product_id', $product->id)->delete();

        $specGroups = json_decode($request->specifications_json, true);
        if (!empty($specGroups) && is_array($specGroups)) {
            foreach ($specGroups as $group) {
            if (empty($group['specs_heading']) && empty($group['specs_headingAr'])) {
                continue;
            }
            $heading = SpecificationHeading::create([
                'product_id' => $product->id,
                'specs_heading' => $group['specs_heading'] ?? '',
                'specs_heading_arabic' => $group['specs_headingAr'] ?? '',
            ]);

            if (!empty($group['specsList']) && is_array($group['specsList'])) {
                foreach ($group['specsList'] as $item) {
                // Skip if all fields are empty
                if (
                    empty($item['specs']) &&
                    empty($item['specsAr']) &&
                    empty($item['value']) &&
                    empty($item['valueAr'])
                ) {
                    continue;
                }
                SpecificationValue::create([
                    'product_id' => $product->id,
                    'specs_heading_id' => $heading->id,
                    'specs' => $item['specs'] ?? '',
                    'specs_arabic'   => $item['specsAr'] ?? '',
                    'value' => $item['value'] ?? '',
                    'value_arabic' => $item['valueAr'] ?? '',
                ]);
                }
            }
            }
        }

        // Remove and re-add upsale items
        UpsaleItems::where('product_id', $product->id)->delete();
        if($request->upsale_items){
            foreach ($request->upsale_items as $upsale) {
            UpsaleItems::create([
                'items_id' => $upsale,
                'product_id' => $product->id
            ]);
            }
        }

        // Remove and re-add related brands
        RelatedBrands::where('product_id', $product->id)->delete();
        if($request->brand){
            foreach ($request->brand as $related_brand) {
            RelatedBrands::create([
                'brand_id' => $related_brand,
                'product_id' => $product->id
            ]);
            }
        }

        // Remove and re-add related categories
        RelatedCategories::where('product_id', $product->id)->delete();
        if($request->category){
            foreach ($request->category as $related_category) {
            RelatedCategories::create([
                'category_id' => $related_category,
                'product_id' => $product->id
            ]);
            }
        }

        // Remove and re-add product faqs
        ProductFaq::where('product_id', $product->id)->delete();
        if($request->product_faqs){
            foreach ($request->product_faqs as $faqs) {
            ProductFaq::create([
                'faq_id' => $faqs,
                'product_id' => $product->id
            ]);
            }
        }

        // Remove and re-add product tags
        ProductTags::where('product_id', $product->id)->delete();
        if($request->product_tags){
            foreach ($request->product_tags as $tags) {
            ProductTags::create([
                'tag_id' => $tags,
                'product_id' => $product->id
            ]);
            }
        }

        // Remove and re-add product categories
        ProductCategories::where('product_id', $product->id)->delete();
        if($request->product_categories){
            foreach ($request->product_categories as $categories) {
            ProductCategories::create([
                'category_id' => $categories,
                'product_id' => $product->id
            ]);
            }
        }

        // Remove and re-add gallery images
        ProductImageGallery::where('product_id', $product->id)->delete();
        $imageUrlsString = $request->input('image_website');
        $imageUrls = array_filter(array_map('trim', explode(',', $imageUrlsString)));
        foreach ($imageUrls as $url) {
            ProductImageGallery::create([
            'product_id' => $product->id,
            'image_url' => $url,
            ]);
        }

        if ($request->has('submit')) {
            return redirect()->route('pim.product.listing')->with('message', 'Product has beeen Updated Successfully!');
        }

        if ($request->has('save')) {
            return redirect()->route('pim.product.edit', ['id' => $product->id])->with('message', 'Product has beeen Updated Successfully!');
        }
    }

    public function delete($id){
        $permission = PermissionHelper::getPermissions('product');
        if (!$permission || !$permission->delete) {
            return redirect()->route('index');
        }

        $product = Product::findOrFail($id);
        $product->delete();
        KeyFeature::where('product_id', $id)->delete();
        SpecificationHeading::where('product_id', $id)->delete();
        SpecificationValue::where('product_id', $id)->delete();
        UpsaleItems::where('product_id', $id)->delete();
        RelatedBrands::where('product_id', $id)->delete();
        RelatedCategories::where('product_id', $id)->delete();
        ProductFaq::where('product_id', $id)->delete();
        ProductTags::where('product_id', $id)->delete();
        ProductCategories::where('product_id', $id)->delete();
        ProductImageGallery::where('product_id', $id)->delete();

        return redirect()->route('pim.product.listing');
    }

    public function multiDelete(Request $request) {
        $permission = PermissionHelper::getPermissions('product');
        if (!$permission || !$permission->delete) {
            return redirect()->route('index');
        }

        $ids = $request->input('ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        if (!empty($ids) && is_array($ids)) {
            Product::whereIn('id', $ids)->delete();
            KeyFeature::whereIn('product_id', $ids)->delete();
            SpecificationHeading::whereIn('product_id', $ids)->delete();
            SpecificationValue::whereIn('product_id', $ids)->delete();
            UpsaleItems::whereIn('product_id', $ids)->delete();
            RelatedBrands::whereIn('product_id', $ids)->delete();
            RelatedCategories::whereIn('product_id', $ids)->delete();
            ProductFaq::whereIn('product_id', $ids)->delete();
            ProductTags::whereIn('product_id', $ids)->delete();
            ProductCategories::whereIn('product_id', $ids)->delete();
            ProductImageGallery::whereIn('product_id', $ids)->delete();
        }

        return redirect()->route('pim.product.listing');
    }
}
