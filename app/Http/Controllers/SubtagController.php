<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tag;
use App\Models\Subtag;
use App\Helpers\PermissionHelper;
use Illuminate\Validation\ValidationException;

class SubtagController extends Controller
{
    public function index($id){
        $permission = PermissionHelper::getPermissions('tags');
        if (!$permission || (!$permission->view && !$permission->view_all)) {
            return redirect()->route('index');
        }

        $subtags = collect();
        if ($permission) {
            if ($permission->view_all) {
                $subtags = Subtag::orderByDesc('id')->where('tag_id', $id)->get();
            } elseif ($permission->view) {
                $subtags = Subtag::where('creator_id', auth()->id())->where('tag_id', $id)->orderByDesc('id')->get();
            }
        }

        return view('pim.tags.subtags.listing', compact('subtags', 'permission'));
    }

    public function store(Request $request){
        $user = Auth::user();
        // dd($request->all());

        try {
            $request->validate([
                'subTagNameEn' => 'required|string|max:255',
                'subTagNameAr' => 'required|string|max:255',
            ], [
                'subTagNameEn.required' => 'Please Enter SubTag Name.',
                'subTagNameAr.required' => 'Please enter SubTag Name - Ar.',
            ]);
// dd($request->all());
            Subtag::create([
                'name' => $request->subTagNameEn,
                'name_ar' => $request->subTagNameAr,
                'sorting' => $request->sorting ?: null,
                'icon' => $request->uploadIcon,
                'image_link_app' => $request->imageLink ?: null,
                'status' => $request->status ? 1 : 0,
                'tag_id' => $request->tag_id,
                'creator_id' => $user->id,
            ]);

            return redirect()->back()->with('message', 'SubTag has beeen Created Successfully!');
        } catch (ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('open_modal', 'create_subtag');
        }
    }

    public function edit($id){
        $permission = PermissionHelper::getPermissions('tags');
        if (!$permission || !$permission->edit) {
            return redirect()->route('index');
        }

        $subtags = Subtag::findOrFail($id);
        session()->flash('open_modal', 'edit_subtag');
        session()->flash('subtag_edit_data', $subtags);
        return redirect()->back();
    }

    public function update(Request $request, $id){
        $user = Auth::user();

        try {
            $request->validate([
                'subTagNameEn' => 'required|string|max:255',
                'subTagNameAr' => 'required|string|max:255',
            ], [
                'subTagNameEn.required' => 'Please Enter SubTag Name.',
                'subTagNameAr.required' => 'Please enter SubTag Name - Ar.',
            ]);

            $subtags = Subtag::findOrFail($id);
            $subtags->update([
                'name' => $request->subTagNameEn,
                'name_ar' => $request->subTagNameAr,
                'sorting' => $request->sorting ?: null,
                'icon' => $request->uploadIcon,
                'image_link_app' => $request->imageLink ?: null,
                'status' => $request->status ? 1 : 0,
            ]);

            return redirect()->back()->with('message', 'SubTag has beeen Updated Successfully!');
        } catch (ValidationException $e) {
            return redirect()
            ->back()
            ->withErrors($e->validator)
            ->withInput()
            ->with('open_modal', 'edit_subtag')
            ->with('subtag_edit_data', Subtag::find($id));
        }
    }

    public function view($id){
        $permission = PermissionHelper::getPermissions('tags');
        if (!$permission || !$permission->edit) {
            return redirect()->route('index');
        }

        $subtag_view = Subtag::findOrFail($id);
        session()->flash('open_modal', 'view_tag');
        session()->flash('subtag_view_data', $subtag_view);
        return redirect()->back();
    }

    public function delete($id){
        $permission = PermissionHelper::getPermissions('tags');
        if (!$permission || !$permission->delete) {
            return redirect()->route('index');
        }

        $subtag = Subtag::findOrFail($id);
        $subtag->delete();

        return redirect()->back();
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
        if (!empty($ids) && is_array($ids)) {
            Subtag::whereIn('id', $ids)->delete();
        }

        return redirect()->back();
    }
}
