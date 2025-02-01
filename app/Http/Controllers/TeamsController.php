<?php

namespace App\Http\Controllers;

use App\Models\Teams;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use PHPUnit\TextUI\CliArguments\Exception;

class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Teams::orderBy('created_at', 'desc')->paginate(10);
        return view('backend.Manageteams.lists', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.Manageteams.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|min:5|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // Allow uploaded images
            'cropped_image' => 'nullable|string', // Allow base64 cropped image data
            'position' => 'required	|min:5',
        ]);

        try {
            $folderPath = 'teams_images'; // Directory to store images in 'storage/app/public'
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
                $imagesized->resize(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                });
                Storage::disk('public')->put("$folderPath/$image_name", $imagesized->encode('jpg', 90));

            }

            // Save blog data
            Teams::create([
                'name' => $request->input('name'),
                'position' => $request->input('position'),
                'image' => $image_name ? "$folderPath/$image_name" : null, // Path relative to storage/app/public
            ]);

            return redirect()->route('teams.index')->with('success', 'Team created successfully.');

        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(Teams $team)
    {
        return view('backend.Manageteams.create', compact('team'));
    }

    public function update(Request $request, Teams $team)
    {
        $request->validate([
            'name' => 'required|string|min:5|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // Allow uploaded images
            'cropped_image' => 'nullable|string', // Allow base64 cropped image data
            'position' => 'required|min:5',
        ]);

        try {
            $folderPath = 'teams_images'; // Directory to store images in 'storage/app/public'
            $image_name = $team->image; // Keep the old image path by default

            // Handle cropped image
            if ($request->filled('cropped_image')) {
                // Delete the old image if it exists
                if ($team->image && Storage::disk('public')->exists($team->image)) {
                    Storage::disk('public')->delete($team->image);
                }

                $croppedImage = $request->input('cropped_image'); // Get the base64 image
                $imageData = explode(',', $croppedImage)[1]; // Remove "data:image/png;base64," prefix
                $decodedImage = base64_decode($imageData);

                $image_name = time() . '_cropped.jpg'; // Define the image name
                $storedPath = "$folderPath/$image_name";
                Storage::disk('public')->put($storedPath, $decodedImage); // Store in the specified folder

            } elseif ($request->hasFile('thumbnail')) {
                // Delete the old image if it exists
                if ($team->image && Storage::disk('public')->exists($team->image)) {
                    Storage::disk('public')->delete($team->image);
                }

                $image = $request->file('thumbnail');
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                $imagesized = Image::make($image);
                $imagesized->resize(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $storedPath = "$folderPath/$image_name";
                Storage::disk('public')->put($storedPath, $imagesized->encode('jpg', 90));
            } else {
                $storedPath = $team->image; // Retain old image path if no new image is provided
            }

            // Update blog data
            $team->update([
                'name' => $request->input('name'),
                'position' => $request->input('position'),
                'image' => $storedPath ? $storedPath : null,
            ]);

            return redirect()->route('teams.index')->with('success', 'Team updated successfully.');

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
            $team = Teams::onlyTrashed()->findOrFail($id);

            // Check if the team has an image and delete it from storage
            if ($team->image && Storage::disk('public')->exists($team->image)) {
                Storage::disk('public')->delete($team->image);
            }

            // Permanently delete the team
            $team->forceDelete();

            // Success notification
            return redirect()->back()->with('success', 'Team deleted successfully.');
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
                'team_publish_status' => 'required|in:1,0',
            ]);

            // Find blog or fail
            $team = Teams::findOrFail($id);

            // Update the publish status
            $team->team_publish_status = $request->team_publish_status;
            $team->save();



            return redirect()->route('teams.index')->with('success', 'Team published successfully.');

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
            'team_publish_status' => 'required|in:1,0',

        ]);
        try {
            $team = Teams::find($id);
            $team->team_publish_status = $request->team_publish_status;
            $team->save();

            return redirect()->route('teams.index', $team->id)->with('success', 'Team unpublished successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function trashDelete(Request $request, $id)
    {
        try {
            $team = Teams::find($id);
            $team->delete();

            return redirect()->route('teams.index')->with('success', 'Team moved to trash successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function trashView(Request $request)
    {
        $search = $request->input('search');

        // Retrieve only trashed blogs with optional search functionality
        $teams_trash = Teams::onlyTrashed()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(30); // Adjusted pagination to match trash-specific listing

        return view('Backend.Manageteams.trash_view', compact('teams_trash'));
    }

    public function restore(Request $request, $id)
    {
        try {
            $team = Teams::onlyTrashed()->find($id);
            $team->restore();

            return redirect()->route('teams.index')->with('success', 'Team restored successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}