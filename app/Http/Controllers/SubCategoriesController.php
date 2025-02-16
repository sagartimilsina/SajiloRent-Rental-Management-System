<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use App\Models\SubCategories;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SubCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $userRole = Auth::user()->role->role_name;

        // Fetch categories based on the user's role
        if ($userRole == 'Admin') {
            $subCategories = SubCategories::with('user:id,name', 'category:id,category_name,created_by')
                ->orderBy('created_at', 'desc')
                ->where(
                    function ($query) use ($search) {
                        $query->where('sub_category_name', 'like', '%' . $search . '%');
                    }
                )
                ->paginate(30);
        } elseif ($userRole == 'Super Admin') {
            $subCategories = SubCategories::with('user:id,name', 'category:id,category_name,created_by')
                ->orderBy('created_at', 'desc')
                ->where(
                    function ($query) use ($search) {
                        $query->where('sub_category_name', 'like', '%' . $search . '%');
                    }
                )
                ->paginate(30);
        } else {
            return redirect()->back()->with('error', 'You are not authorized to access this page.');
        }
        $Categories = Categories::all();
        return view('backend.ManageCategory.subcategories', compact('subCategories', 'Categories'));
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
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'categories' => 'required|json',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Decode the categories JSON input
        $categories = json_decode($request->input('categories'), true);

        foreach ($categories as $category) {
            // Validate individual category data
            $categoryValidator = Validator::make($category, [
                'category_id' => 'required|exists:categories,id',
                'sub_category_name' => 'required|string|max:255',
                'icon' => 'nullable|string', // Base64 string
                'created_by' => 'required|exists:users,id',
            ]);

            if ($categoryValidator->fails()) {
                return back()->with('error', $categoryValidator->errors()->all())->withInput();
            }

            $iconPath = null;

            // Handle Base64 image if provided
            if (!empty($category['icon'])) {
                // Extract the file extension from the Base64 data
                $iconData = explode(',', $category['icon']);
                $fileData = base64_decode($iconData[1]);
                $mimeType = finfo_buffer(finfo_open(), $fileData, FILEINFO_MIME_TYPE);
                $extension = explode('/', $mimeType)[1];

                // Generate a unique filename and save the file
                $fileName = uniqid('icon_', true) . '.' . $extension;
                $iconPath = "subcategories/$fileName";
                Storage::disk('public')->put($iconPath, $fileData);
            }

            // Save the subcategory
            SubCategories::create([
                'category_id' => $category['category_id'],
                'sub_category_name' => $category['sub_category_name'],
                'icon' => $iconPath, // Save the file path
                'created_by' => $category['created_by'],
                'publish_status' => false, // Default value
            ]);
        }

        return redirect()->route('subCategories.index')->with('success', 'Subcategories saved successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(SubCategories $subCategories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCategories $subCategories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'created_by' => 'required|exists:users,id',
            'sub_category_name' => 'required',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Find the subcategory by ID
        $subCategory = SubCategories::findOrFail($id);

        // Update the subcategory attributes
        $subCategory->category_id = $request->category_id;
        $subCategory->created_by = $request->created_by;
        $subCategory->sub_category_name = $request->sub_category_name;

        // Check if an image file was uploaded
        if ($request->hasFile('icon')) {
            // Delete the previous image if it exists
            if ($subCategory->icon && Storage::disk('public')->exists($subCategory->icon)) {
                Storage::disk('public')->delete($subCategory->icon);
            }

            // Upload the new image
            $image = $request->file('icon');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'subcategories/' . $imageName;
            $image->storeAs('public/' . 'subcategories', $imageName);

            // Update the subcategory with the new image path
            $subCategory->icon = $imagePath;
        }

        // Save the updated subcategory
        $subCategory->save();

        return redirect()->route('subCategories.index')->with('success', 'Subcategory updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
        try {
            // Retrieve the blog from the trash
            $blog = SubCategories::onlyTrashed()->findOrFail($id);

            // Check if the blog has an image and delete it from storage
            if ($blog->icon && Storage::disk('public')->exists($blog->icon)) {
                Storage::disk('public')->delete($blog->icon);
            }

            // Permanently delete the blog
            $blog->forceDelete();

            // Success notification
            return redirect()->back()->with('success', 'Sub Category deleted successfully.');
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
            $blog = SubCategories::findOrFail($id);

            // Update the publish status
            $blog->publish_status = $request->publish_status;
            $blog->save();
            return redirect()->route('subCategories.index')->with('success', 'Sub Category published successfully.');
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
            $blog = SubCategories::find($id);
            $blog->publish_status = $request->publish_status;
            $blog->save();

            return redirect()->route('subCategories.index', $blog->id)->with('success', 'Sub Category unpublished successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function trashDelete(Request $request, $id)
    {
        try {
            $blog = SubCategories::find($id);
            $blog->delete();

            return redirect()->route('subCategories.index')->with('success', 'Sub Category moved to trash successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function trashView(Request $request)
    {
        $search = $request->input('search');

        // Retrieve only trashed blogs with optional search functionality
        $categories_trash = SubCategories::onlyTrashed()
            ->when($search, function ($query, $search) {
                return $query->where('category_name', 'like', '%' . $search . '%');
            })
            ->where('created_by', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(30); // Adjusted pagination to match trash-specific listing

        return view('Backend.ManageCategory.subcategories-trash', compact('categories_trash'));
    }

    public function restore(Request $request, $id)
    {
        try {
            $blog = SubCategories::onlyTrashed()->find($id);
            $blog->restore();

            return redirect()->route('subCategories.index')->with('success', 'Sub Category restored successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
