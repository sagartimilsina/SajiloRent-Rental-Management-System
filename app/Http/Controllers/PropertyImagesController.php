<?php

namespace App\Http\Controllers;

use App\Models\Propeerty;
use Illuminate\Http\Request;
use App\Models\Property_Images;
use Illuminate\Support\Facades\Storage;

class PropertyImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $property = Propeerty::find($id);
        // return $property;
        $property_images = Property_Images::where('property_id', $id)
            ->orderBy('id', 'desc')
            ->get();
        
        
        // return $property_images;
        return view('Backend.ManageProducts.property_images_index', compact('property', 'property_images' ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'property_id' => 'required|exists:propeerties,id',
            'images' => 'required|array|min:1|max:15',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:5120', // Max size 2MB per image
        ]);

        // Retrieve the property
        $property = Propeerty::findOrFail($request->property_id);

        // Process each uploaded file
        $uploadedImages = [];
        foreach ($request->file('images') as $image) {
            // Store the file and get its path
            $image_name = uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('property_images', $image_name, 'public');


            // Save image details in the database
            $uploadedImages[] = Property_Images::create([
                'property_id' => $property->id,
                'property_image' => $path,
            ]);
        }

        // Redirect back with success message
        return redirect()->back()->with('success', count($uploadedImages) . ' images uploaded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Property_Images $property_Images)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property_Images $property_Images)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property_Images $property_Images)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        try {
            $property = Property_Images::onlyTrashed()->findorFail($id);

            if ($property->property_image && Storage::disk('public')->exists($property->property_image)) {
                Storage::disk('public')->delete($property->property_image);
            }
            $property->forcedelete();
            return redirect()->back()->with('success', 'Property image deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function publish(Request $request, $id)
    {

        try {
            // Manually validating the incoming request
            $validatedData = $request->validate([
                'publish_status' => 'required|in:1,0',
            ]);


            // Find blog or fail
            $blog = Property_Images::findOrFail($id);

            // Update the publish status
            $blog->property_publish_status = $request->publish_status;
            $blog->save();



            return redirect()->back()->with('success', 'Property Images published successfully.');

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
            'publish_status' => 'required|in:1,0',

        ]);
        try {
            $blog = Property_Images::find($id);
            $blog->property_publish_status = $request->publish_status;
            $blog->save();

            return redirect()->back()->with('success', 'Property Images unpublished successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function trashDelete(Request $request, $id)
    {
        try {
            $blog = Property_Images::find($id);
            $blog->delete();


            return redirect()->back()->with('success', 'Property Image moved to trash successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function trashView(Request $request, $id)
    {


        // Retrieve only trashed Property Images, with optional search
        $query = Property_Images::onlyTrashed()
            ->orderBy('created_at', 'desc');

        // If there's a search term, apply search logic


        // Paginate results, fetching 30 per page
        $blogs_trash = $query->paginate(30);
        if ($blogs_trash->isEmpty()) {

            return redirect()->route('products.images', $id)->with('error', 'No Property Images found in the trash.');
        }


        // Fetch property_ids from the retrieved records
        $property_ids = $blogs_trash->pluck('property_id')->unique();




        // If you want to return the data as a view:
        return view('Backend.ManageProducts.trash_Images_view', compact('blogs_trash', 'property_ids', 'id'));
    }

    public function restore(Request $request, $id)
    {
        try {
            $blog = Property_Images::onlyTrashed()->find($id);
            $blog->restore();

            return redirect()->back()->with('success', 'Property Image restored successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
