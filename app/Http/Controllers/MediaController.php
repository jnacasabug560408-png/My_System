<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Filter: Admin sees everything, Editor sees only their own
        if ($user->isAdmin()) {
            $media = Media::with('user')->latest()->paginate(20);
        } else {
            $media = Media::where('user_id', $user->id)->latest()->paginate(20);
        }

        return view('media.index', compact('media'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:20480|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx,mp4,avi,mov',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads', 'public');
            
            Media::create([
                'filename' => basename($path),
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
                'url' => '/storage/' . $path,
                'user_id' => Auth::id(),
            ]);

            return redirect()->route('media.index')->with('success', 'File uploaded successfully!');
        }

        return back()->with('error', 'Upload failed.');
    }

   public function destroy($id)
{
    $media = \App\Models\Media::findOrFail($id);
    $user = Auth::user();

    // Sinisiguro natin na (int) ang comparison para walang mismatch
    if ($user->role === 'admin' || (int)$user->id === (int)$media->user_id) {
        
        // 1. Kunin ang tamang path para sa Storage::delete
        // Tatanggalin ang '/storage/' prefix kung meron man
        $path = str_replace('/storage/', '', $media->url);
        $path = ltrim($path, '/');

        // 2. Burahin ang file kung nage-exist
        if (\Storage::disk('public')->exists($path)) {
            \Storage::disk('public')->delete($path);
        }

        // 3. Burahin ang record sa database
        $media->delete();

        return redirect()->route('media.index')->with('success', 'Media deleted successfully!');
    }

    abort(403, 'Forbidden: You are not the owner of this file.');
}}