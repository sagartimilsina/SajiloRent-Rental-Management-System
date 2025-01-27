<?php

namespace App\Http\Controllers;

use App\Models\Abouts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AboutsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $abouts = Abouts::orderBy('created_at', 'desc')->get();
        return view('backend.ManageAbout.lists', compact('abouts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.ManageAbout.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'head' => 'required|string',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $about = new Abouts();
        $about->head = $validatedData['head'];
        $about->title = $validatedData['title'];
        $about->description = $validatedData['description'];


        // Handle image upload
        if ($request->filled('cropped_image')) {
            // Handle base64 image
            $imageData = str_replace(['data:image/png;base64,', ' '], ['', '+'], $request->input('cropped_image'));
            $filename = 'about_' . uniqid() . '.jpg';
            $path = 'public/about_images/' . $filename;

            // Save the image
            Storage::put($path, base64_decode($imageData));
            $about->image = str_replace('public/', '', $path);
        } elseif ($request->hasFile('thumbnail')) {
            // Handle file upload
            $filename = 'about_' . uniqid() . '.jpg';
            $path = $request->file('thumbnail')->storeAs('public/about_images', $filename);
            $about->image = str_replace('public/', '', $path);
        }


        $about->save();

        return redirect()->route('abouts.index')->with('success', 'About information created successfully');
    }

    public function edit($id)
    {
        $about = Abouts::find($id);
        return view('backend.ManageAbout.create', compact('about'));
    }

    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'head' => 'required|string',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $about = Abouts::findOrFail($id);

        // Delete existing image if new image is provided
        if (($request->filled('cropped_image') || $request->hasFile('thumbnail')) && $about->image) {
            $oldImagePath = storage_path('app/public/' . $about->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        $about->head = $validatedData['head'];
        $about->title = $validatedData['title'];
        $about->description = $validatedData['description'];

        // Handle image upload
        if ($request->filled('cropped_image')) {
            $imageData = str_replace(['data:image/png;base64,', ' '], ['', '+'], $request->input('cropped_image'));
            $filename = 'about_' . uniqid() . '.jpg';
            $path = 'public/about_images/' . $filename;

            Storage::put($path, base64_decode($imageData));
            $about->image = str_replace('public/', '', $path);
        } elseif ($request->hasFile('thumbnail')) {
            $filename = 'about_' . uniqid() . '.jpg';
            $path = $request->file('thumbnail')->storeAs('public/about_images', $filename);
            $about->image = str_replace('public/', '', $path);
        }

        $about->save();

        return redirect()->route('abouts.index')->with('success', 'About information updated successfully');
    }

    public function destroy($id)
    {
        $about = Abouts::findOrFail($id);

        // Delete associated image
        if ($about->image) {
            $imagePath = storage_path('app/public/' . $about->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $about->delete();

        return redirect()->route('abouts.index')->with('success', 'About information deleted successfully');
    }

    public function publish(Request $request, $id)
    {
        try {
            // Manually validating the incoming request
            $validatedData = $request->validate([
                'about_publish_status' => 'required|in:1,0',
            ]);

            // Find blog or fail
          $about = Abouts::findOrFail($id);

            // Update the publish status
          $about->about_publish_status = $request->about_publish_status;
          $about->save();



            return redirect()->route('abouts.index')->with('success', 'About information published successfully.');

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
            'about_publish_status' => 'required|in:1,0',

        ]);
        try {
          $about = Abouts::find($id);
          $about->about_publish_status = $request->about_publish_status;
          $about->save();

            return redirect()->route('abouts.index', $about->id)->with('success', 'About information unpublished successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
