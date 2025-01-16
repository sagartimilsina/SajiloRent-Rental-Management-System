<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Blogs;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Use a single query with conditional logic for filtering
        $blogs = Blogs::when($search, function ($query, $search) {
            $query->where('blog_title', 'like', '%' . $search . '%');
        })
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        return view('Backend.blogs.lists', compact('blogs'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Backend.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:5|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // Allow uploaded images
            'cropped_image' => 'nullable|string', // Allow base64 cropped image data
            'description' => 'nullable|min:5',
        ]);

        try {
            $folderPath = 'blogs_images'; // Directory to store images in 'storage/app/public'
            $image_name = null;

            // Handle cropped image
            if ($request->filled('cropped_image')) {
                $croppedImage = $request->input('cropped_image'); // Get the base64 image
                $imageData = explode(',', $croppedImage)[1]; // Remove "data:image/png;base64," prefix
                $decodedImage = base64_decode($imageData);

                $image_name = time() . '_cropped.jpg'; // Define the image name
                Storage::disk('public')->put("$folderPath/$image_name", $decodedImage); // Store in the specified folder
            } elseif ($request->hasFile('thumbnail')) {
                $image = $request->file('thumbnail');
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                $imagesized = Image::make($image);
                $imagesized->resize(1024, 1024, function ($constraint) {
                    $constraint->aspectRatio();
                });
                Storage::disk('public')->put("$folderPath/$image_name", $imagesized->encode('jpg', 90));

            }

            // Save blog data
            Blogs::create([
                'blog_title' => $request->input('title'),
                'blog_description' => $request->input('description'),
                'blog_image' => $image_name ? "$folderPath/$image_name" : null, // Path relative to storage/app/public
            ]);

            return redirect()->route('blogs.index')->with('success', 'Blog created successfully.');

        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }





    /**
     * Display the specified resource.
     */
    public function show(Blogs $blogs)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blogs $blog)
    {
        return view('Backend.blogs.create', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blogs $blog)
    {
        $request->validate([
            'title' => 'required|string|min:5|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // Allow uploaded images
            'cropped_image' => 'nullable|string', // Allow base64 cropped image data
            'description' => 'nullable|min:5',
        ]);

        try {
            $folderPath = 'blogs_images'; // Directory to store images in 'storage/app/public'
            $image_name = $blog->blog_image; // Keep the old image path by default

            // Handle cropped image
            if ($request->filled('cropped_image')) {
                // Delete the old image if it exists
                if ($blog->blog_image && Storage::disk('public')->exists($blog->blog_image)) {
                    Storage::disk('public')->delete($blog->blog_image);
                }

                $croppedImage = $request->input('cropped_image'); // Get the base64 image
                $imageData = explode(',', $croppedImage)[1]; // Remove "data:image/png;base64," prefix
                $decodedImage = base64_decode($imageData);

                $image_name = time() . '_cropped.jpg'; // Define the image name
                $storedPath = "$folderPath/$image_name";
                Storage::disk('public')->put($storedPath, $decodedImage); // Store in the specified folder

            } elseif ($request->hasFile('thumbnail')) {
                // Delete the old image if it exists
                if ($blog->blog_image && Storage::disk('public')->exists($blog->blog_image)) {
                    Storage::disk('public')->delete($blog->blog_image);
                }

                $image = $request->file('thumbnail');
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                $imagesized = Image::make($image);
                $imagesized->resize(1024, 1024, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $storedPath = "$folderPath/$image_name";
                Storage::disk('public')->put($storedPath, $imagesized->encode('jpg', 90));
            } else {
                $storedPath = $blog->blog_image; // Retain old image path if no new image is provided
            }

            // Update blog data
            $blog->update([
                'blog_title' => $request->input('title'),
                'blog_description' => $request->input('description'),
                'blog_image' => $storedPath ? $storedPath : null,
            ]);

            return redirect()->route('blogs.index')->with('success', 'Blog updated successfully.');

        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Retrieve the blog from the trash
            $blog = Blogs::onlyTrashed()->findOrFail($id);

            // Check if the blog has an image and delete it from storage
            if ($blog->blog_image && Storage::disk('public')->exists($blog->blog_image)) {
                Storage::disk('public')->delete($blog->blog_image);
            }

            // Permanently delete the blog
            $blog->forceDelete();

            // Success notification
            return redirect()->back()->with('success', 'Blog deleted successfully.');
        } catch (\Exception $e) {
            // Error notification


            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function publish(Request $request, $id)
    {
        try {
            // Manually validating the incoming request
            $validatedData = $request->validate([
                'blog_publish_status' => 'required|in:1,0',
            ]);

            // Find blog or fail
            $blog = Blogs::findOrFail($id);

            // Update the publish status
            $blog->blog_publish_status = $request->blog_publish_status;
            $blog->save();



            return redirect()->route('blogs.index')->with('success', 'Blog published successfully.');

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
            'blog_publish_status' => 'required|in:1,0',

        ]);
        try {
            $blog = Blogs::find($id);
            $blog->blog_publish_status = $request->blog_publish_status;
            $blog->save();

            return redirect()->route('blogs.index', $blog->id)->with('success', 'Blog unpublished successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function trashDelete(Request $request, $id)
    {
        try {
            $blog = Blogs::find($id);
            $blog->delete();

            return redirect()->route('blogs.index')->with('success', 'Blog moved to trash successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function trashView(Request $request)
    {
        $search = $request->input('search');

        // Retrieve only trashed blogs with optional search functionality
        $blogs_trash = Blogs::onlyTrashed()
            ->when($search, function ($query, $search) {
                return $query->where('blog_title', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(30); // Adjusted pagination to match trash-specific listing

        return view('Backend.blogs.trash_view', compact('blogs_trash'));
    }

    public function restore(Request $request, $id)
    {
        try {
            $blog = Blogs::onlyTrashed()->find($id);
            $blog->restore();

            return redirect()->route('blogs.index')->with('success', 'Blog restored successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // public function destroy_comments($id)
    // {
    //     try {
    //         $blog = BlogsComment::find($id);
    //         $blog->delete();
    //         $notification = array(
    //             'message' => 'Blog comments deleted successfully',
    //             'alert-type' => 'success'
    //         );
    //         return redirect()->back()->with($notification);
    //     } catch (\Exception $e) {
    //         $notification = array(
    //             'message' => $e->getMessage(),
    //             'alert-type' => 'error'
    //         );
    //         return redirect()->back()->with($notification);
    //     }
    // }


}
