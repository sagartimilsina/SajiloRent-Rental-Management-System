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
                if ($request->hasFile('thumbnail')) {
                    $videoPath = $request->file('thumbnail')->store('galleries/videos', 'public');
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

    public function loadMore(Request $request)
    {
        $type = $request->input('type'); // 'image' or 'video'
        $page = $request->input('page', 1); // Default to page 1

        $query = Gallery::where('gallery_publish_status', 1)
            ->where('gallery_type', $type)
            ->orderBy('created_at', 'desc');

        $items = $query->paginate($type === 'image' ? 16 : 4, ['*'], 'page', $page);

        $html = '';
        foreach ($items as $item) {
            if ($type === 'image') {
                $html .= '<div class="col-md-3 col-sm-6 mb-4">' .
                    '<div class="gallery-item" data-bs-toggle="modal" data-bs-target="#imageModal"' .
                    ' data-bs-image="' . asset('storage/' . $item->gallery_file) . '"' .
                    ' data-bs-title="' . $item->gallery_name . '">' .
                    '<img alt="' . $item->gallery_name . '" height="300"' .
                    ' src="' . asset('storage/' . $item->gallery_file) . '" width="300" />' .
                    '<div class="overlay">' . $item->gallery_name . '</div>' .
                    '</div>' .
                    '</div>';
            } else {
                $html .= '<div class="col-md-3 col-sm-6">' .
                    '<div class="gallery-item" data-bs-toggle="modal" data-bs-target="#galleryModal"' .
                    ' data-src="' . asset('storage/' . $item->gallery_file) . '" data-type="video"' .
                    ' data-title="' . $item->gallery_name . '">' .
                    '<video muted><source src="' . asset('storage/' . $item->gallery_file) . '" type="video/mp4"></video>' .
                    '<div class="overlay">' . $item->gallery_name . '</div>' .
                    '</div>' .
                    '</div>';
            }
        }

        return response()->json([
            'html' => $html,
            'nextPage' => $items->currentPage() + 1,
            'hasMorePages' => $items->hasMorePages()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        return view('backend.ManageGallery.show', compact('gallery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        return view('backend.ManageGallery.create', compact('gallery'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
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
                if ($request->hasFile('thumbnail')) {
                    $videoPath = $request->file('thumbnail')->store('galleries/videos', 'public');
                    $gallery->gallery_file = $videoPath;
                }
            }
            // Save the gallery information to the database
            $gallery->gallery_type = $request->input('gallery_type');
            $gallery->gallery_name = $request->input('gallery_name');
            $gallery->save();

            // Redirect or respond with success
            return redirect()->route('galleries.index')->with('success', 'Gallery updated successfully');
        } catch (\Exception $e) {
            // Catch any error and return the message
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        dd($gallery);
        try {
            // Delete the associated file from storage
            if ($gallery->gallery_file && Storage::disk('public')->exists($gallery->gallery_file)) {
                Storage::disk('public')->delete($gallery->gallery_file);
            }

            // Delete the gallery record from the database
            $gallery->delete();

            return redirect()->route('galleries.index')->with('success', 'Gallery deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store a cropped image from base64 data.
     */
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

    /**
     * Store an uploaded image and resize it.
     */
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

    // public function destroy($id)
    // {
    //     try {
    //         // Retrieve the blog from the trash
    //         $blog = Blogs::onlyTrashed()->findOrFail($id);

    //         // Check if the blog has an image and delete it from storage
    //         if ($blog->blog_image && Storage::disk('public')->exists($blog->blog_image)) {
    //             Storage::disk('public')->delete($blog->blog_image);
    //         }

    //         // Permanently delete the blog
    //         $blog->forceDelete();

    //         // Success notification
    //         return redirect()->back()->with('success', 'Blog deleted successfully.');
    //     } catch (\Exception $e) {
    //         // Error notification


    //         return redirect()->back()->with('error', $e->getMessage());
    //     }
    // }
    public function publish(Request $request, $id)
    {
        try {
            // Manually validating the incoming request
            $validatedData = $request->validate([
                'gallery_publish_status' => 'required|in:1,0',
            ]);

            // Find blog or fail
            $blog = Gallery::findOrFail($id);

            // Update the publish status
            $blog->gallery_publish_status = $request->gallery_publish_status;
            $blog->save();



            return redirect()->route('galleries.index')->with('success', 'Gallery published successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle the validation failure case
            $errors = implode(', ', array_map(function ($error) {
                return implode(', ', $error);
            }, $e->errors())); // Convert errors array to a string


            // Redirect back with the error notification and input
            return redirect()->back()->with('error', $errors)->withInput();
        } catch (\Exception $e) {
            // General exception handling
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function unpublish(Request $request, $id)
    {
        $request->validate([
            'gallery_publish_status' => 'required|in:1,0',

        ]);
        try {
            $blog = Gallery::find($id);
            $blog->gallery_publish_status = $request->gallery_publish_status;
            $blog->save();

            return redirect()->route('galleries.index', $blog->id)->with('success', 'Gallery unpublished successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    // public function trashDelete(Request $request, $id)
    // {
    //     try {
    //         $blog = Blogs::find($id);
    //         $blog->delete();

    //         return redirect()->route('blogs.index')->with('success', 'Blog moved to trash successfully.');
    //     } catch (\Exception $e) {

    //         return redirect()->back()->with('error', $e->getMessage());
    //     }
    // }
    // public function trashView(Request $request)
    // {
    //     $search = $request->input('search');

    //     // Retrieve only trashed blogs with optional search functionality
    //     $blogs_trash = Blogs::onlyTrashed()
    //         ->when($search, function ($query, $search) {
    //             return $query->where('blog_title', 'like', '%' . $search . '%');
    //         })
    //         ->orderBy('created_at', 'desc')
    //         ->paginate(30); // Adjusted pagination to match trash-specific listing

    //     return view('Backend.blogs.trash_view', compact('blogs_trash'));
    // }

    // public function restore(Request $request, $id)
    // {
    //     try {
    //         $blog = Blogs::onlyTrashed()->find($id);
    //         $blog->restore();

    //         return redirect()->route('blogs.index')->with('success', 'Blog restored successfully.');
    //     } catch (\Exception $e) {

    //         return redirect()->back()->with('error', $e->getMessage());
    //     }
    // }
}
