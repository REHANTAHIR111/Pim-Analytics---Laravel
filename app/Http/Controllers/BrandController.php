<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\BrandCategories;
use App\Models\Brand;
use App\Helpers\PermissionHelper;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    public function index() {
        $permission = PermissionHelper::getPermissions('brand');
        if (!$permission || (!$permission->view && !$permission->view_all)) {
            return redirect()->route('index');
        }

        $brand = collect();
        if ($permission) {
            if ($permission->view_all) {
                $brand = Brand::orderByDesc('id')->get();;
            } elseif ($permission->view) {
                $brand = Brand::where('creator_id', auth()->id())->orderByDesc('id')->get();
            }
        }

        return view('pim.brand.listing', compact('brand', 'permission'));
    }

    public function create(Request $request) {
        $permission = PermissionHelper::getPermissions('brand');
        $categoriesPerm = PermissionHelper::getPermissions('categories');

        if (!$permission || !$permission->create) {
            return redirect()->route('index');
        }

        $catOptions = collect();

        if($categoriesPerm){
            if ($categoriesPerm->view_all) {
                $catOptions = Categories::where('status', 1)->get();
            } elseif ($categoriesPerm->view) {
                $catOptions = Categories::where('creator_id', auth()->id())->where('status', 1)->get();
            }
        }

        return view('pim.brand.add', compact('catOptions'));
    }

    public function store(Request $request) {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'nameAr' => 'required|string|max:255',
            'sorting' => 'required|int|max:50',
        ], [
            'name.required' => 'Please fill Name - En.',
            'nameAr.required' => 'Please fill Name - Ar.',
            'sorting.required' => 'Please fill Sorting.',
        ]);

        Brand::create([
            'name' => $request->name,
            'name_arabic' => $request->nameAr,
            'slug' => basename($request->slug),
            'h1_en' => $request->h1,
            'h1_arabic' => $request->h1Ar,
            'description' => $request->brand_description,
            'description_arabic' => $request->brand_descriptionAr,
            'meta_title' => $request->metatitle,
            'meta_title_arabic' => $request->metatitleAr,
            'meta_description' => $request->metadescription,
            'meta_description_arabic' => $request->metadescriptionAr,
            'meta_tags' => $request->metatags,
            'meta_tags_arabic' => $request->metatagsAr,
            'content_title' => $request->contenttitle,
            'content_title_arabic' => $request->contenttitleAr,
            'content_description' => $request->contentdescription,
            'content_description_arabic' => $request->contentdescriptionAr,
            'status' => $request->status ? 1 : 0,
            'popular_brand' => $request->popular_brand ? 1 : 0,
            'show_in_front' => $request->show_in_front ? 1 : 0,
            'image_link' => $request->image_link,
            'mobile_image' => $request->image_mobile,
            'website_image' => $request->image_website,
            'creator_id' => $user->id,
            'sorting' => $request->sorting,
        ]);
        $brand = Brand::latest('id')->first();

        if($request->selectCats){
            foreach ($request->selectCats as $cat_ids) {
                BrandCategories::create([
                    'category_id' => $cat_ids,
                    'brand_id' => $brand->id
                ]);
            }
        }

        if ($request->has('submit')) {
            return redirect()->route('pim.brand.listing')->with('message', 'Brand has beeen Created Successfully!');
        }

        if ($request->has('save')) {
            return redirect()->route('pim.brand.edit', ['id' => $brand->id])->with('message', 'Brand has beeen Created Successfully!');
        }
    }

    public function edit($id) {
        $permission = PermissionHelper::getPermissions('brand');
        $catPerm = PermissionHelper::getPermissions('categories');

        if (!$permission || !$permission->edit) {
            return redirect()->route('index');
        }

        $catOptions = collect();

        if($catPerm){
            if ($catPerm->view_all) {
                $catOptions = Categories::where('status', 1)->where('id', '!=', $id)->get();
            } elseif ($catPerm->view) {
                $catOptions = Categories::where('creator_id', auth()->id())->where('status', 1)->where('id', '!=', $id)->get();
            }
        }

        $brand = Brand::with('categories')->findOrFail($id);
        $selectedCats = $brand->categories->pluck('id')->toArray();

        return view('pim.brand.edit', compact('brand', 'selectedCats', 'catOptions'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'nameAr' => 'required|string|max:255',
            'sorting' => 'required|int|max:50',
        ], [
            'name.required' => 'Please fill Name - En.',
            'nameAr.required' => 'Please fill Name - Ar.',
            'sorting.required' => 'Please fill Sorting.',
        ]);

        $brand = Brand::findOrFail($id);
        $brand->update([
            'name' => $request->name,
            'name_arabic' => $request->nameAr,
            'slug' => basename($request->slug),
            'h1_en' => $request->h1,
            'h1_arabic' => $request->h1Ar,
            'description' => $request->brand_description,
            'description_arabic' => $request->brand_descriptionAr,
            'meta_title' => $request->metatitle,
            'meta_title_arabic' => $request->metatitleAr,
            'meta_description' => $request->metadescription,
            'meta_description_arabic' => $request->metadescriptionAr,
            'meta_tags' => $request->metatags,
            'meta_tags_arabic' => $request->metatagsAr,
            'content_title' => $request->contenttitle,
            'content_title_arabic' => $request->contenttitleAr,
            'content_description' => $request->contentdescription,
            'content_description_arabic' => $request->contentdescriptionAr,
            'status' => $request->status ? 1 : 0,
            'popular_brand' => $request->popular_brand ? 1 : 0,
            'show_in_front' => $request->show_in_front ? 1 : 0,
            'image_link' => $request->image_link,
            'mobile_image' => $request->image_mobile,
            'website_image' => $request->image_website,
            'sorting' => $request->sorting,
        ]);

        BrandCategories::where('brand_id', $id)->delete();
        if($request->selectCats){
            foreach ($request->selectCats as $cat_ids) {
                BrandCategories::create([
                    'category_id' => $cat_ids,
                    'brand_id' => $brand->id
                ]);
            }
        }

        if ($request->has('submit')) {
            return redirect()->route('pim.brand.listing')->with('message', 'Brand has beeen Updated Successfully!');
        }

        if ($request->has('save')) {
            return back()->with('message', 'Brand has beeen Updated Successfully!');
        }
    }

    public function view($id) {
        $permission = PermissionHelper::getPermissions('brand');
        $catPerm = PermissionHelper::getPermissions('categories');

        if (!$permission || !$permission->edit) {
            return redirect()->route('index');
        }

        $catOptions = collect();

        if($catPerm){
            if ($catPerm->view_all) {
                $catOptions = Categories::where('status', 1)->where('id', '!=', $id)->get();
            } elseif ($catPerm->view) {
                $catOptions = Categories::where('creator_id', auth()->id())->where('status', 1)->where('id', '!=', $id)->get();
            }
        }

        $brand = Brand::with('categories')->findOrFail($id);
        $selectedCats = $brand->categories->pluck('id')->toArray();

        return view('pim.brand.view', compact('brand', 'selectedCats', 'catOptions'));
    }

    public function delete($id){
        $permission = PermissionHelper::getPermissions('brand');
        if (!$permission || !$permission->delete) {
            return redirect()->route('index');
        }

        $brand = Brand::findOrFail($id);
        $brand->delete();
        BrandCategories::where('brand_id', $id)->delete();

        return redirect()->route('pim.brand.listing');
    }

    public function multiDelete(Request $request) {
        $permission = PermissionHelper::getPermissions('brand');
        if (!$permission || !$permission->delete) {
            return redirect()->route('index');
        }

        $ids = $request->input('ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        if (!empty($ids) && is_array($ids)) {
            Brand::whereIn('id', $ids)->delete();
            BrandCategories::whereIn('brand_id', $ids)->delete();
        }

        return redirect()->route('pim.brand.listing');
    }
}
