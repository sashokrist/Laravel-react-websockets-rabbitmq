<?php

namespace App\Http\Controllers;

use App\Events\ImageUpdated;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\ImageActionMail;

class GalleryController extends Controller
{
    public function index()
    {
        return Cache::remember('gallery.images', now()->addMinutes(10), function () {
            return Gallery::latest()->get();
        });
    }

    public function store(Request $request)
    {
        $request->validate(['image' => 'required|image|max:2048']);

        $path = $request->file('image')->store('images', 'public');

        $image = Gallery::create([
            'image_path' => $path,
        ]);

        // Forget cache to refresh image list
        Cache::forget('gallery.images');

        Mail::to('your@email.com')->queue(new ImageActionMail($image, 'added'));
        broadcast(new ImageUpdated($image->id, 'added'))->toOthers();

        return response()->json($image, 201);
    }

    public function destroy($id)
    {
        $image = Gallery::find($id);
        if (!$image) {
            return response()->json(['error' => 'Image not found.'], 404);
        }

        $imageData = clone $image;
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        // Forget cache to refresh image list
        Cache::forget('gallery.images');

        Mail::to('your@email.com')->queue(new ImageActionMail($imageData, 'deleted'));
        broadcast(new ImageUpdated($imageData->id, 'deleted'))->toOthers();

        return response()->json(['success' => true]);
    }
}
