<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userRole = Auth::user()->role->role_name;

        // Fetch categories based on the user's role
        if ($userRole == 'Admin') {
            $categories = Categories::with('user:id,name')
                ->where('created_by', Auth::id())
                ->orderBy('created_at', 'desc')
                ->paginate(30);
        } elseif ($userRole == 'Super Admin') {
            $categories = Categories::with('user:id,name')
                ->orderBy('created_at', 'desc')
                ->paginate(30);
        } else {
            return redirect()->back()->with('error', 'You are not authorized to access this page.');
        }

        return view('backend.ManageCategory.main', compact('categories'));
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
            'categories' => 'required|json',

        ]);

        // Decode the categories JSON
        $categories = json_decode($request->categories, true);

        // Iterate and save categories
        foreach ($categories as $categoryData) {
            Categories::create([
                'category_name' => $categoryData['name'],
                'icon' => $this->saveBase64Image($categoryData['icon']),
                'created_by' => $categoryData['created_by'],
            ]);
        }

        return redirect()->back()->with('success', 'Categories added successfully!');
    }

    /**
     * Save a base64 image to the public storage and return the file path.
     *
     * @param string $base64Image
     * @return string|null
     */


    private function saveBase64Image($base64Image)
    {

        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
            $data = substr($base64Image, strpos($base64Image, ',') + 1);
            $type = strtolower($type[1]); // jpeg, png, gif



            $data = base64_decode($data);

            // Check if decoding was successful
            if ($data === false) {
                return null;
            }

            $fileName = uniqid() . '.' . $type;

            // Save the file to the 'categories' directory in the 'public' disk
            $filePath = 'categories/' . $fileName;
            Storage::disk('public')->put($filePath, $data);

            return $filePath; // Returns the relative file path (e.g., "categories/unique_id.jpg")
        }

        return null;
    }




    /**
     * Display the specified resource.
     */
    public function show(Categories $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categories $categories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'category_name' => 'required|max:255',
            'created_by' => 'required|exists:users,id',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

        ]);

        // Find the blog by ID
        $category = Categories::findOrFail($id);

        // Update the blog attributes
        $category->category_name = $request->category_name;
        $category->created_by = $request->created_by;

        // Check if an image file was uploaded
        if ($request->hasFile('icon')) {
            // Delete the previous image if it exists
            if ($category->icon && Storage::disk('public')->exists($category->icon)) {
                Storage::disk('public')->delete($category->icon);
            }

            // Upload the new image
            $image = $request->file('icon');
            $path = $image->store('categories', 'public');
            $category->icon = $path;
        }

        // Save the updated blog
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Retrieve the blog from the trash
            $blog = Categories::onlyTrashed()->findOrFail($id);

            // Check if the blog has an image and delete it from storage
            if ($blog->icon && Storage::disk('public')->exists($blog->icon)) {
                Storage::disk('public')->delete($blog->icon);
            }

            // Permanently delete the blog
            $blog->forceDelete();

            // Success notification
            return redirect()->back()->with('success', 'Category deleted successfully.');
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
                'publish_status' => 'required|in:1,0',
            ]);

            // Find blog or fail
            $blog = Categories::findOrFail($id);

            // Update the publish status
            $blog->publish_status = $request->publish_status;
            $blog->save();



            return redirect()->route('categories.index')->with('success', 'Category published successfully.');

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
            $blog = Categories::find($id);
            $blog->publish_status = $request->publish_status;
            $blog->save();

            return redirect()->route('categories.index', $blog->id)->with('success', 'Category unpublished successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function trashDelete(Request $request, $id)
    {
        try {
            $blog = Categories::find($id);
            $blog->delete();

            return redirect()->route('categories.index')->with('success', 'Category moved to trash successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function trashView(Request $request)
    {
        $search = $request->input('search');

        // Retrieve only trashed blogs with optional search functionality
        $categories_trash = Categories::onlyTrashed()
            ->when($search, function ($query, $search) {
                return $query->where('category_name', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(30); // Adjusted pagination to match trash-specific listing

        return view('Backend.ManageCategory.trash_view', compact('categories_trash'));
    }

    public function restore(Request $request, $id)
    {
        try {
            $blog = Categories::onlyTrashed()->find($id);
            $blog->restore();

            return redirect()->route('categories.index')->with('success', 'Category restored successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
