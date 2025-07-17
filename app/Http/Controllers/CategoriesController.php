<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Categories_Filter;
use App\Models\Subtag;
use App\Helpers\PermissionHelper;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    public function index() {
        $permission = PermissionHelper::getPermissions('categories');
        if (!$permission || (!$permission->view && !$permission->view_all)) {
            return redirect()->route('index');
        }

        $categories = collect();
        if ($permission) {
            if ($permission->view_all) {
                $categories = Categories::orderByDesc('id')->get();;
            } elseif ($permission->view) {
                $categories = Categories::where('creator_id', auth()->id())->orderByDesc('id')->get();
            }
        }

        return view('pim.categories.listing', compact('categories', 'permission'));
    }

    public function create(Request $request) {
        $permission = PermissionHelper::getPermissions('categories');
        $catPerm = PermissionHelper::getPermissions('categories');
        $subtagPerm = PermissionHelper::getPermissions('tags');

        if (!$permission || !$permission->create) {
            return redirect()->route('index');
        }

        $cats = collect();
        $subTagsOptions = collect();

        if($catPerm){
            if ($catPerm->view_all) {
                $cats = Categories::where('status', 1)->get();
            } elseif ($catPerm->view) {
                $cats = Categories::where('creator_id', auth()->id())->where('status', 1)->get();
            }
        }

        if($subtagPerm){
            if ($subtagPerm->view_all) {
                $subTagsOptions = Subtag::where('status', 1)->get();
            } elseif ($subtagPerm->view) {
                $subTagsOptions = Subtag::where('creator_id', auth()->id())->where('status', 1)->get();
            }
        }
        return view('pim.categories.add', compact('cats', 'subTagsOptions'));
    }

    public function store(Request $request) {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'nameAr' => 'required|string|max:255',
            'redirection_link' => 'required|url|max:255',
        ], [
            'name.required' => 'Please fill Name - En.',
            'nameAr.required' => 'Please fill Name - Ar.',
            'redirection_link.required' => 'Please fill Redirection link.',
            'redirection_link.url' => 'Redirection link must be a valid URL.',
        ]);

        Categories::create([
            'name' => $request->name,
            'name_arabic' => $request->nameAr,
            'slug' => basename($request->slug),
            'h1_en' => $request->h1,
            'h1_arabic' => $request->h1Ar,
            'description' => $request->category_description,
            'description_arabic' => $request->category_descriptionAr,
            'meta_title' => $request->metatitle,
            'meta_title_arabic' => $request->metatitleAr,
            'meta_canonical' => $request->meta_canonical,
            'meta_canonical_arabic' => $request->meta_canonicalAr,
            'meta_description' => $request->metadescription,
            'meta_description_arabic' => $request->metadescriptionAr,
            'meta_tags' => $request->metatags,
            'meta_tags_arabic' => $request->metatagsAr,
            'content_title' => $request->contenttitle,
            'content_title_arabic' => $request->contenttitleAr,
            'content_description' => $request->contentdescription,
            'content_description_arabic' => $request->contentdescriptionAr,
            'status' => $request->status ? 1 : 0,
            'not_for_export' => $request->not_for_export ? 1 : 0,
            'show_in_menu' => $request->show_in_menu ? 1 : 0,
            'show_on_arabyads' => $request->show_on_arabyads ? 1 : 0,
            'nofollow_analytics' => $request->no_follow ? 1 : 0,
            'noindex_analytics' => $request->no_index ? 1 : 0,
            'redirection_link' => $request->redirection_link,
            'sell_type' => $request->selltype,
            'value' => $request->value,
            'parent_category' => $request->selectCat,
            'icon' => $request->upload_icon,
            'brand_link' => $request->brand_link,
            'image_link' => $request->image_link,
            'mobile_image' => $request->image_mobile,
            'website_image' => $request->image_website,
            'creator_id' => $user->id,
            'sorting' => $request->sorting,
        ]);
        $category = Categories::latest('id')->first();

        if($request->selectSubtag){
            foreach ($request->selectSubtag as $subtag) {
                Categories_Filter::create([
                    'filter_id' => $subtag,
                    'category_id' => $category->id
                ]);
            }
        }

        if ($request->has('submit')) {
            return redirect()->route('pim.categories.listing')->with('message', 'Category has beeen Created Successfully!');
        }

        if ($request->has('save')) {
            return redirect()->route('pim.categories.edit', ['id' => $category->id])->with('message', 'Category has beeen Created Successfully!');
        }
    }

    public function edit($id) {
        $permission = PermissionHelper::getPermissions('categories');
        $catPerm = PermissionHelper::getPermissions('categories');
        $subtagPerm = PermissionHelper::getPermissions('tags');

        if (!$permission || !$permission->edit) {
            return redirect()->route('index');
        }

        $cats = collect();
        $subTagsOptions = collect();

        if($catPerm){
            if ($catPerm->view_all) {
                $cats = Categories::where('status', 1)->where('id', '!=', $id)->get();
            } elseif ($catPerm->view) {
                $cats = Categories::where('creator_id', auth()->id())->where('status', 1)->where('id', '!=', $id)->get();
            }
        }

        if($subtagPerm){
            if ($subtagPerm->view_all) {
                $subTagsOptions = Subtag::where('status', 1)->get();
            } elseif ($subtagPerm->view) {
                $subTagsOptions = Subtag::where('creator_id', auth()->id())->where('status', 1)->get();
            }
        }

        $category = Categories::with('filters')->findOrFail($id);
        $selectedFilters = $category->filters->pluck('id')->toArray();

        return view('pim.categories.edit', compact('category', 'cats', 'selectedFilters', 'subTagsOptions'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'nameAr' => 'required|string|max:255',
            'redirection_link' => 'required|url|max:255',
        ], [
            'name.required' => 'Please fill Name - En.',
            'nameAr.required' => 'Please fill Name - Ar.',
            'redirection_link.required' => 'Please fill Redirection link.',
            'redirection_link.url' => 'Redirection link must be a valid URL.',
        ]);

        $category = Categories::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'name_arabic' => $request->nameAr,
            'slug' => basename($request->slug),
            'h1_en' => $request->h1,
            'h1_arabic' => $request->h1Ar,
            'description' => $request->category_description,
            'description_arabic' => $request->category_descriptionAr,
            'meta_title' => $request->metatitle,
            'meta_title_arabic' => $request->metatitleAr,
            'meta_canonical' => $request->meta_canonical,
            'meta_canonical_arabic' => $request->meta_canonicalAr,
            'meta_description' => $request->metadescription,
            'meta_description_arabic' => $request->metadescriptionAr,
            'meta_tags' => $request->metatags,
            'meta_tags_arabic' => $request->metatagsAr,
            'content_title' => $request->contenttitle,
            'content_title_arabic' => $request->contenttitleAr,
            'content_description' => $request->contentdescription,
            'content_description_arabic' => $request->contentdescriptionAr,
            'status' => $request->status ? 1 : 0,
            'not_for_export' => $request->not_for_export ? 1 : 0,
            'show_in_menu' => $request->show_in_menu ? 1 : 0,
            'show_on_arabyads' => $request->show_on_arabyads ? 1 : 0,
            'nofollow_analytics' => $request->no_follow ? 1 : 0,
            'noindex_analytics' => $request->no_index ? 1 : 0,
            'redirection_link' => $request->redirection_link,
            'sell_type' => $request->selltype,
            'value' => $request->value,
            'parent_category' => $request->selectCat,
            'icon' => $request->upload_icon,
            'brand_link' => $request->brand_link,
            'image_link' => $request->image_link,
            'mobile_image' => $request->image_mobile,
            'website_image' => $request->image_website,
            'sorting' => $request->sorting,
        ]);

        Categories_Filter::where('category_id', $id)->delete();
        if($request->selectSubtag){
            foreach ($request->selectSubtag as $subtag) {
                Categories_Filter::create([
                    'filter_id' => $subtag,
                    'category_id' => $category->id
                ]);
            }
        }

        if ($request->has('submit')) {
            return redirect()->route('pim.categories.listing')->with('message', 'Category has beeen Updated Successfully!');
        }

        if ($request->has('save')) {
            return back()->with('message', 'Category has beeen Updated Successfully!');
        }
    }

    public function view($id) {
        $permission = PermissionHelper::getPermissions('categories');
        $catPerm = PermissionHelper::getPermissions('categories');
        $subtagPerm = PermissionHelper::getPermissions('tags');

        if (!$permission || !$permission->edit) {
            return redirect()->route('index');
        }

        $cats = collect();
        $subTagsOptions = collect();

        if($catPerm){
            if ($catPerm->view_all) {
                $cats = Categories::where('status', 1)->where('id', '!=', $id)->get();
            } elseif ($catPerm->view) {
                $cats = Categories::where('creator_id', auth()->id())->where('status', 1)->where('id', '!=', $id)->get();
            }
        }

        if($subtagPerm){
            if ($subtagPerm->view_all) {
                $subTagsOptions = Subtag::where('status', 1)->get();
            } elseif ($subtagPerm->view) {
                $subTagsOptions = Subtag::where('creator_id', auth()->id())->where('status', 1)->get();
            }
        }

        $category = Categories::with('filters')->findOrFail($id);
        $selectedFilters = $category->filters->pluck('id')->toArray();

        return view('pim.categories.view', compact('category', 'cats', 'selectedFilters', 'subTagsOptions'));
    }

    public function delete($id){
        $permission = PermissionHelper::getPermissions('categories');
        if (!$permission || !$permission->delete) {
            return redirect()->route('index');
        }

        $cat = Categories::findOrFail($id);
        $cat->delete();
        Categories_Filter::where('category_id', $id)->delete();

        return redirect()->route('pim.categories.listing');
    }

    public function multiDelete(Request $request) {
        $permission = PermissionHelper::getPermissions('categories');
        if (!$permission || !$permission->delete) {
            return redirect()->route('index');
        }

        $ids = $request->input('ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        if (!empty($ids) && is_array($ids)) {
            Categories::whereIn('id', $ids)->delete();
            Categories_Filter::whereIn('category_id', $ids)->delete();
        }

        return redirect()->route('pim.categories.listing');
    }
}
