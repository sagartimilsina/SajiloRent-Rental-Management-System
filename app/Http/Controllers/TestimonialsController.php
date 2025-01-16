<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Testimonials;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class TestimonialsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $testimonials = Testimonials::when($search, function ($query, $search) {
            $query->where('name', 'like', '%'. $search. '%');
        })
            ->orderBy('created_at', 'desc')->paginate(30);
        return view('backend.testimonials.lists', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'name' => 'required|string|min:5|max:255',
            'position' => 'required|string|max:255', // Ensure 'position' is validated
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'cropped_image' => 'nullable|string',
            'description' => 'nullable|min:5',
            'rating' => 'required|numeric|min:1|max:5',
        ]);

        try {
            $folderPath = 'testimonials_images'; // Directory for storing images
            $image_name = null;

            // Handle cropped image
            if ($request->filled('cropped_image')) {
                $croppedImage = $request->input('cropped_image');
                $imageData = explode(',', $croppedImage)[1]; // Remove "data:image/png;base64," prefix
                $decodedImage = base64_decode($imageData);

                $image_name = time() . '_cropped.jpg';
                Storage::disk('public')->put("$folderPath/$image_name", $decodedImage); // Store in 'public' disk
            } elseif ($request->hasFile('thumbnail')) {
                // Handle uploaded thumbnail
                $image = $request->file('thumbnail');
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                $imagesized = Image::make($image);
                $imagesized->resize(1024, 1024, function ($constraint) {
                    $constraint->aspectRatio();
                });
                Storage::disk('public')->put("$folderPath/$image_name", $imagesized->encode('jpg', 90));
            }

            // Save Testimonials data
            Testimonials::create([
                'name' => $validated['name'],
                'position' => $validated['position'],
                'description' => $validated['description'],
                'rating' => $validated['rating'],
                'image' => $image_name ? "$folderPath/$image_name" : null,
                'testimonials_publish_status' => false,
            ]);

            // Redirect to index route with success message
            return redirect()->route('testimonials.index')->with('success', 'Testimonial created successfully.');
        } catch (Exception $e) {
            // Log the exception and redirect back with an error message
            // \Log::error('Testimonial Creation Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Testimonials $testimonials, $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonials $testimonials, $id)
    {
        $testimonial = Testimonials::findOrFail($id);
        return view('backend.testimonials.create', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonials $testimonials, $id)
    {
        // Validate request
        $validated = $request->validate([
            'name' => 'required|string|min:5|max:255',
            'position' => 'required|string|max:255', // Ensure 'position' is validated
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'cropped_image' => 'nullable|string',
            'description' => 'nullable|min:5',
            'rating' => 'required|numeric|min:1|max:5',
        ]);
        try {
            $testimonial = Testimonials::findOrFail($id);
            $folderPath = 'testimonials_images'; // Directory to store images in 'storage/app/public'
            $image_name = $testimonial->image; // Keep the old image path by default

            // Handle cropped image
            if ($request->filled('cropped_image')) {
                // Delete the old image if it exists
                if ($testimonial->image && Storage::disk('public')->exists($testimonial->image)) {
                    Storage::disk('public')->delete($testimonial->image);
                }

                $croppedImage = $request->input('cropped_image'); // Get the base64 image
                $imageData = explode(',', $croppedImage)[1]; // Remove "data:image/png;base64," prefix
                $decodedImage = base64_decode($imageData);

                $image_name = time() . '_cropped.jpg'; // Define the image name
                $storedPath = "$folderPath/$image_name";
                Storage::disk('public')->put($storedPath, $decodedImage); // Store in the specified folder

            } elseif ($request->hasFile('thumbnail')) {
                // Delete the old image if it exists
                if ($testimonial->image && Storage::disk('public')->exists($testimonial->image)) {
                    Storage::disk('public')->delete($testimonial->image);
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
                $storedPath = $testimonial->image; // Retain old image path if no new image is provided
            }

            $testimonial->update([
                'name' => $request->input('name'),
                'position' => $request->input('position'),
                'description' => $request->input('description'),
                'rating' => $request->input('rating'),
                'image' => $storedPath,
            ]);

            return redirect()->route('testimonials.index')->with('success', 'Testimonial updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonials $testimonials, $id)
    {
        try {
            // Retrieve the trashed testimonial
            $testimonial = Testimonials::onlyTrashed()->findOrFail($id);

            // Check if the testimonial has an image and delete it
            if ($testimonial->image && Storage::disk('public')->exists($testimonial->image)) {
                Storage::disk('public')->delete($testimonial->image);
            }

            // Permanently delete the testimonial
            $testimonial->forceDelete();

            return redirect()->back()->with('success', 'Testimonial permanently deleted.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    /**
     * Publish the specified testimonial.
     */
    public function publish(Request $request, $id)
    {
        try {
            // Manually validating the incoming request
            $validatedData = $request->validate([
                'testimonials_publish_status' => 'required|in:1,0',
            ]);

            // Find testimonial or fail
            $testimonial = Testimonials::findOrFail($id);

            // Update the publish status
            $testimonial->testimonials_publish_status = $request->testimonials_publish_status;
            $testimonial->save();



            return redirect()->route('testimonials.index')->with('success', 'testimonial published successfully.');
        } catch (\Exception $e) {
            // General exception handling
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function unpublish(Request $request, $id)
    {
        $request->validate([
            'testimonials_publish_status' => 'required|in:1,0',
        ]);
        try {
            $testimonial = Testimonials::findOrFail($id);
            $testimonial->testimonials_publish_status = $request->testimonials_publish_status;
            $testimonial->save();

            return redirect()->route('testimonials.index', $testimonial->id)->with('success', 'testimonial unpublished successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function trashDelete(Request $request, $id)
    {
        try {
            $testimonial = Testimonials::findOrFail($id);
            $testimonial->delete(); // Soft delete

            return redirect()->route('testimonials.index')->with('success', 'Testimonial moved to trash.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * View trashed testimonials.
     */
    public function trashView(Request $request)
    {
        $search = $request->input('search');

        // Retrieve only trashed testimonials with optional search functionality
        $testimonials = Testimonials::onlyTrashed()
            ->when($search, function ($query, $search) {
                return $query->where('testimonial_title', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(30); // Adjusted pagination to match trash-specific listing

        return view('backend.testimonials.trash_view', compact('testimonials'));
    }
    /**
     * Restore a trashed testimonial.
     */
    public function restore(Request $request, $id)
    {
        try {
            $testimonial = Testimonials::onlyTrashed()->find($id);
            $testimonial->restore();

            return redirect()->route('testimonials.index')->with('success', 'testimonial restored successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
