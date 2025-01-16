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

        $testimonials = Testimonials::when($search, function($query,$search){
            $query->when('name','like','%',$search,'%');
        })
        ->orderBy('created_at', 'desc')->paginate(30);
       return view('backend.testimonials.lists',compact('testimonials'));
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
        'name' => 'required|string|max:255',
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
        \Log::error('Testimonial Creation Error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
    }
}


    /**
     * Display the specified resource.
     */
    public function show(Testimonials $testimonials)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonials $testimonials)
    {
        {
            return view('Backend.testimonials.create', compact('testimonial'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonials $testimonials)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonials $testimonials)
    {
        //
    }
}
