<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\ImageActionMail;
use App\Events\ImageUpdated;
use App\Http\Controllers\Controller;


class GalleryController extends Controller
{
    public function index() {
        return Gallery::all();
    }

    public function store(Request $request) {
        $path = $request->file('image')->store('images', 'public');
        $image = Gallery::create(['image_path' => $path]);
        Mail::to('your@email.com')->queue(new ImageActionMail($image, 'added'));
        broadcast(new ImageUpdated($image->id, 'added'))->toOthers();
        return response()->json($image);
    }
public function destroy($id)
{
    $gallery = Gallery::find($id);

    if (!$gallery) {
        return response()->json(['error' => 'Image not found.'], 404);
    }

    // 🔐 Capture required info before deletion
    $imagePath = $gallery->image_path;
    $imageData = clone $gallery;

    // Delete file and DB entry
    Storage::disk('public')->delete($imagePath);
    $gallery->delete();

    // ✅ Use preserved data for events/mails
    Mail::to('your@email.com')->queue(new ImageActionMail($imageData, 'deleted'));
    broadcast(new ImageUpdated($imageData->id, 'deleted'))->toOthers();

    return response()->json(['success' => true]);
}


}
