<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Faq;
use App\Helpers\PermissionHelper;
use Illuminate\Validation\ValidationException;

class FaqController extends Controller
{
    public function index(){
        $permission = PermissionHelper::getPermissions('productFaqs');
        if (!$permission || (!$permission->view && !$permission->view_all)) {
            return redirect()->route('index');
        }

        $productFaqs = collect();
        if ($permission) {
            if ($permission->view_all) {
                $productFaqs = Faq::orderByDesc('id')->get();
            } elseif ($permission->view) {
                $productFaqs = Faq::where('creator_id', auth()->id())->orderByDesc('id')->get();
            }
        }

        return view('pim.productFaqs.listing', compact('productFaqs', 'permission'));
    }

    public function store(Request $request){
        $user = Auth::user();

        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'question_english' => 'required|string|max:255',
                'question_arabic' => 'nullable|string|max:255',
                'answer_english' => 'required|string',
                'answer_arabic' => 'nullable|string',
            ], [
                'title.required' => 'Please enter Title.',
                'question_english.required' => 'Please enter Question.',
                'answer_english.required' => 'Please enter Answer.',
            ]);

            Faq::create([
                'title' => $request->title,
                'question_english' => $request->question_english,
                'question_arabic' => $request->question_arabic ?: null,
                'answer_english' => $request->answer_english,
                'answer_arabic' => $request->answer_arabic ?: null,
                'status' => $request->status ? 1 : 0,
                'creator_id' => $user->id,
            ]);

            return redirect()->route('pim.productFaqs.listing')->with('message', 'FAQ has beeen Created Successfully!');
        } catch (ValidationException $e) {
            return redirect()
                ->route('pim.productFaqs.listing')
                ->withErrors($e->validator)
                ->withInput()
                ->with('open_modal', 'create_faq');
        }
    }

    public function edit($id){
        $permission = PermissionHelper::getPermissions('productFaqs');
        if (!$permission || !$permission->edit) {
            return redirect()->route('index');
        }

        $faq = Faq::findOrFail($id);
        session()->flash('open_modal', 'edit_faq');
        session()->flash('faq_edit_data', $faq);
        return redirect()->route('pim.productFaqs.listing');
    }

    public function update(Request $request, $id){
        $user = Auth::user();

        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'question_english' => 'required|string|max:255',
                'question_arabic' => 'nullable|string|max:255',
                'answer_english' => 'required|string',
                'answer_arabic' => 'nullable|string',
            ], [
                'title.required' => 'Please enter Title.',
                'question_english.required' => 'Please enter Question.',
                'answer_english.required' => 'Please enter Answer.',
            ]);

            $faq = Faq::findOrFail($id);
            $faq->update([
                'title' => $request->title,
                'question_english' => $request->question_english,
                'question_arabic' => $request->question_arabic ?: null,
                'answer_english' => $request->answer_english,
                'answer_arabic' => $request->answer_arabic ?: null,
                'status' => $request->status ? 1 : 0,
            ]);

            return redirect()->route('pim.productFaqs.listing')->with('message', 'FAQ has beeen Updated Successfully!');
        } catch (ValidationException $e) {
            return redirect()
            ->route('pim.productFaqs.listing')
            ->withErrors($e->validator)
            ->withInput()
            ->with('open_modal', 'edit_faq')
            ->with('faq_edit_data', Faq::find($id));
        }
    }

    public function view($id){
        $permission = PermissionHelper::getPermissions('productFaqs');
        if (!$permission || !$permission->edit) {
            return redirect()->route('index');
        }

        $faq_view = Faq::findOrFail($id);
        session()->flash('open_modal', 'view_faq');
        session()->flash('faq_view_data', $faq_view);
        return redirect()->route('pim.productFaqs.listing');
    }

    public function delete($id){
        $permission = PermissionHelper::getPermissions('productFaqs');
        if (!$permission || !$permission->delete) {
            return redirect()->route('index');
        }

        $faq = Faq::findOrFail($id);
        $faq->delete();

        return redirect()->route('pim.productFaqs.listing');
    }

    public function multiDelete(Request $request) {
        $permission = PermissionHelper::getPermissions('productFaqs');
        if (!$permission || !$permission->delete) {
            return redirect()->route('index');
        }

        $ids = $request->input('ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        if (!empty($ids) && is_array($ids)) {
            Faq::whereIn('id', $ids)->delete();
        }

        return redirect()->route('pim.productFaqs.listing');
    }
}
