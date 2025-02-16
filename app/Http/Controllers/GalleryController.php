<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::orderBy('created_at', 'desc')->paginate(15);
        return view('backend.ManageGallery.lists', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.ManageGallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'gallery_type' => 'required|in:Image,Video',
            'gallery_name' => 'required|string',
            'thumbnail' => 'nullable|file|mimes:jpeg,png,jpg,mp4',
            'cropped_image' => 'nullable|string',
        ]);

         try {
        $folderPath = 'gallery_images'; // This is your storage folder
        $imageName = null;
        $imagePath = null;

        $gallery = new Gallery();
        // Check for cropped image or regular uploaded image
        if ($request->gallery_type == 'Image') {
            if ($request->filled('cropped_image')) {
                $imageName = $this->storeCroppedImage($request->input('cropped_image'), $folderPath);
                $imagePath = "$folderPath/$imageName"; // Store the relative file path
                $gallery->gallery_file = $imagePath; // Store relative path to gallery file
            } elseif ($request->hasFile('thumbnail')) {
                $imageName = $this->storeUploadedImage($request->file('thumbnail'), $folderPath);
                $imagePath = "$folderPath/$imageName"; // Store the relative file path
                $gallery->gallery_file = $imagePath; // Store relative path to gallery file
            }
        } elseif ($request->gallery_type == 'Video') {
            // Handle video upload
            if ($request->hasFile('video')) {
                $videoPath = $request->file('video')->store('galleries/videos', 'public');
                $gallery->gallery_file = $videoPath;
            }
        }
        // Save the gallery information to the database
        $gallery->gallery_type = $request->input('gallery_type');
        $gallery->gallery_name = $request->input('gallery_name');

        $gallery->property_id = '0'; // Assuming `property_id` is set to '0' for now
        $gallery->save();

        // Redirect or respond with success
        return redirect()->route('galleries.index')->with('success', 'Gallery added successfully');
        } catch (\Exception $e) {
            // Catch any error and return the message
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    private function storeCroppedImage($base64Image, $folderPath)
    {
        // Decode the base64 image data
        $imageData = explode(',', $base64Image)[1];
        $decodedImage = base64_decode($imageData);
        $imageName = time() . '_cropped.jpg'; // Generate the file name

        // Ensure the folder exists, and then save the image to storage
        if (!Storage::disk('public')->exists($folderPath)) {
            Storage::disk('public')->makeDirectory($folderPath);
        }

        Storage::disk('public')->put("$folderPath/$imageName", $decodedImage); // Save the image
        return $imageName;
    }

    private function storeUploadedImage($file, $folderPath)
    {
        // Generate the file name based on current time and file extension
        $imageName = time() . '.' . $file->getClientOriginalExtension();
        $resizedImage = Image::make($file)->resize(1024, 1024, function ($constraint) {
            $constraint->aspectRatio(); // Maintain aspect ratio while resizing
        });

        // Ensure the folder exists
        if (!Storage::disk('public')->exists($folderPath)) {
            Storage::disk('public')->makeDirectory($folderPath);
        }

        // Save the resized image
        Storage::disk('public')->put("$folderPath/$imageName", $resizedImage->encode('jpg', 90));
        return $imageName;
    }


    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        //
    }
}
