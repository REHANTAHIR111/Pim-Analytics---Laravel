<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tag;
use App\Helpers\PermissionHelper;
use Illuminate\Validation\ValidationException;

class TagController extends Controller
{
    public function index(){
        $permission = PermissionHelper::getPermissions('tags');
        if (!$permission || (!$permission->view && !$permission->view_all)) {
            return redirect()->route('index');
        }

        $tags = collect();
        if ($permission) {
            if ($permission->view_all) {
                $tags = Tag::with(['subtags:id,tag_id,name'])->orderByDesc('id')->get();
                // dd($tags);
            } elseif ($permission->view) {
                $tags = Tag::with(['subtags:id,tag_id,name'])->where('creator_id', auth()->id())->orderByDesc('id')->get();
            }
        }

        return view('pim.tags.listing', compact('tags', 'permission'));
    }

    public function store(Request $request){
        $user = Auth::user();

        try {
            $request->validate([
                'tagNameEn' => 'required|string|max:255',
                'tagNameAr' => 'required|string|max:255',
            ], [
                'tagNameEn.required' => 'Please Enter Tag Name.',
                'tagNameAr.required' => 'Please enter Tag Name - Ar.',
            ]);

            Tag::create([
                'name' => $request->tagNameEn,
                'name_ar' => $request->tagNameAr,
                'sorting' => $request->sorting ?: null,
                'icon' => $request->uploadIcon,
                'image_link_app' => $request->imageLink ?: null,
                'status' => $request->status ? 1 : 0,
                'creator_id' => $user->id,
            ]);

            return redirect()->route('pim.tags.listing')->with('message', 'Tag has beeen Created Successfully!');
        } catch (ValidationException $e) {
            return redirect()
                ->route('pim.tags.listing')
                ->withErrors($e->validator)
                ->withInput()
                ->with('open_modal', 'create_tag');
        }
    }

    public function edit($id){
        $permission = PermissionHelper::getPermissions('tags');
        if (!$permission || !$permission->edit) {
            return redirect()->route('index');
        }

        $tag = Tag::findOrFail($id);
        session()->flash('open_modal', 'edit_tag');
        session()->flash('tag_edit_data', $tag);
        return redirect()->route('pim.tags.listing');
    }

    public function update(Request $request, $id){
        $user = Auth::user();

        try {
            $request->validate([
                'tagNameEn' => 'required|string|max:255',
                'tagNameAr' => 'required|string|max:255',
            ], [
                'tagNameEn.required' => 'Please Enter Tag Name.',
                'tagNameAr.required' => 'Please enter Tag Name - Ar.',
            ]);

            $tag = Tag::findOrFail($id);
            $tag->update([
                'name' => $request->tagNameEn,
                'name_ar' => $request->tagNameAr,
                'sorting' => $request->sorting ?: null,
                'icon' => $request->uploadIcon,
                'image_link_app' => $request->imageLink ?: null,
                'status' => $request->status ? 1 : 0,
            ]);

            return redirect()->route('pim.tags.listing')->with('message', 'Tag has beeen Updated Successfully!');
        } catch (ValidationException $e) {
            return redirect()
            ->route('pim.tags.listing')
            ->withErrors($e->validator)
            ->withInput()
            ->with('open_modal', 'edit_tag')
            ->with('tag_edit_data', Tag::find($id));
        }
    }

    public function view($id){
        $permission = PermissionHelper::getPermissions('tags');
        if (!$permission || !$permission->edit) {
            return redirect()->route('index');
        }

        $tag_view = Tag::findOrFail($id);
        session()->flash('open_modal', 'view_tag');
        session()->flash('tag_view_data', $tag_view);
        return redirect()->route('pim.tags.listing');
    }

    public function delete($id){
        $permission = PermissionHelper::getPermissions('tags');
        if (!$permission || !$permission->delete) {
            return redirect()->route('index');
        }

        $tag = Tag::findOrFail($id);

        $subtags = $tag->subtags;
        foreach ($subtags as $subtag) {
            $subtag->delete();
        }
        $tag->delete();

        return redirect()->route('pim.tags.listing');
    }

    public function multiDelete(Request $request) {
        $permission = PermissionHelper::getPermissions('tags');
        if (!$permission || !$permission->delete) {
            return redirect()->route('index');
        }

        $ids = $request->input('ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }

        $tags = Tag::with('subtags')->whereIn('id', $ids)->get();
        foreach ($tags as $tag) {
            foreach ($tag->subtags as $subtag) {
                $subtag->delete();
            }
            $tag->delete();
        }

        return redirect()->route('pim.tags.listing');
    }
}
