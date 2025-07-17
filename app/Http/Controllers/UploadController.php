<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function handle(Request $request){
        if (!$request->hasFile('file')) {
            return response()->json(['success' => false, 'error' => 'No file uploaded.']);
        }

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('uploads', $fileName, 'public');

        if ($path) {
            return response()->json([
                'success' => true,
                'url' => asset('storage/' . $path),
            ]);
        }

        return response()->json(['success' => false, 'error' => 'Upload failed.']);
    }
}
