<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\SliderImages;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class SliderImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $sliderImages = SliderImages::orderBy('created_at', 'desc')
            ->when($request->search, function ($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%');
            })

            ->paginate(10);
        return view('backend.sliders.lists', compact('sliderImages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|min:5|max:255',
            'sub_title' => 'nullable|string|min:5|max:255',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:25600', // Allow uploaded images
            'cropped_image' => 'nullable|string', // Allow base64 cropped image data

        ]);

        try {
            $folderPath = 'sliders_images'; // Directory to store images in 'storage/app/public'
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
                $imagesized->resize(1440, 992, function ($constraint) {
                    $constraint->aspectRatio();
                });
                Storage::disk('public')->put("$folderPath/$image_name", $imagesized->encode('jpg', 90));
            }

            // Save blog data
            SliderImages::create([
                'title' => $request->input('title'),
                'sub_title' => $request->input('sub_title'),
                'slider_image' => $image_name ? "$folderPath/$image_name" : null, // Path relative to storage/app/public
            ]);

            return redirect()->route('sliders.index')->with('success', 'Slider created successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SliderImages $sliderImages)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $slider = SliderImages::findOrFail($id);
        return view('backend.sliders.create', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'title' => 'nullable|string|min:5|max:255',
            'sub_title' => 'nullable|string|min:5|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:25600 ', // Allow uploaded images
            'cropped_image' => 'nullable|string', // Allow base64 cropped image data

        ]);

        try {
            $slider = SliderImages::findOrFail($id);
            $folderPath = 'sliders_images'; // Directory to store images in 'storage/app/public'
            $image_name = $slider->slider_image; // Keep the old image path by default

            // Handle cropped image
            if ($request->filled('cropped_image')) {
                // Delete the old image if it exists
                if ($slider->slider_image && Storage::disk('public')->exists($slider->slider_image)) {
                    Storage::disk('public')->delete($slider->slider_image);
                }

                $croppedImage = $request->input('cropped_image'); // Get the base64 image
                $imageData = explode(',', $croppedImage)[1]; // Remove "data:image/png;base64," prefix
                $decodedImage = base64_decode($imageData);

                $image_name = time() . '_cropped.jpg'; // Define the image name
                $storedPath = "$folderPath/$image_name";
                Storage::disk('public')->put($storedPath, $decodedImage); // Store in the specified folder

            } elseif ($request->hasFile('thumbnail')) {
                // Delete the old image if it exists
                if ($slider->slider_image && Storage::disk('public')->exists($slider->slider_image)) {
                    Storage::disk('public')->delete($slider->slider_image);
                }

                $image = $request->file('thumbnail');
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                $imagesized = Image::make($image);
                $imagesized->resize(1440, 992, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $storedPath = "$folderPath/$image_name";
                Storage::disk('public')->put($storedPath, $imagesized->encode('jpg', 90));
            } else {
                $storedPath = $slider->slider_image; // Retain old image path if no new image is provided
            }

            // Update blog data
            $slider->update([
                'title' => $request->input('title'),
                'sub_title' => $request->input('sub_title'),
                'slider_image' => $storedPath ? $storedPath : null,
            ]);

            return redirect()->route('sliders.index')->with('success', 'Slider updated successfully.');
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
            $slider = SliderImages::onlyTrashed()->findOrFail($id);

            // Check if the blog has an image and delete it from storage
            if ($slider->slider_image && Storage::disk('public')->exists($slider->slider_image)) {
                Storage::disk('public')->delete($slider->slider_image);
            }

            // Permanently delete the blog
            $slider->forceDelete();

            // Success notification
            return redirect()->back()->with('success', 'Slider deleted successfully.');
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
                'slider_publish_status' => 'required|in:1,0',
            ]);

            // Find blog or fail
            $slider = SliderImages::findOrFail($id);

            // Update the publish status
            $slider->slider_publish_status = $request->slider_publish_status;
            $slider->save();



            return redirect()->route('sliders.index')->with('success', 'Slider published successfully.');
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
            'slider_publish_status' => 'required|in:1,0',

        ]);
        try {
            $slider = SliderImages::find($id);
            $slider->slider_publish_status = $request->slider_publish_status;
            $slider->save();

            return redirect()->route('sliders.index', $slider->id)->with('success', 'Slider unpublished successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function trashDelete(Request $request, $id)
    {
        try {
            $slider = SliderImages::find($id);
            $slider->delete();

            return redirect()->route('sliders.index')->with('success', 'Slider moved to trash successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function trashView(Request $request)
    {
        $search = $request->input('search');

        // Retrieve only trashed blogs with optional search functionality
        $sliders_trash = SliderImages::onlyTrashed()
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(30); // Adjusted pagination to match trash-specific listing

        return view('Backend.sliders.trash_view', compact('sliders_trash'));
    }

    public function restore(Request $request, $id)
    {
        try {
            $slider = SliderImages::onlyTrashed()->find($id);
            $slider->restore();

            return redirect()->route('sliders.index')->with('success', 'Slider restored successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
