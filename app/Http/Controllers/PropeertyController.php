<?php

namespace App\Http\Controllers;

use App\Models\Propeerty;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SubCategories;
use App\Models\Users_Property;
use App\Models\PropertyMessage;
use App\Mail\PropertyMessageMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class PropeertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $userRole = Auth::user()->role->role_name;
        $userId = Auth::id(); // Get the authenticated user's ID

        if ($userRole == 'Super Admin') {
            $products = Propeerty::orderBy('created_at', 'desc')
                ->with('category:id,category_name', 'subcategory:id,sub_category_name')
                ->when($search, function ($query) use ($search) {
                    $query->where('property_name', 'like', '%' . $search . '%');
                })
                ->paginate(30);
        } elseif ($userRole == 'Admin') {
            $products = Propeerty::orderBy('created_at', 'desc')
                ->with('category:id,category_name', 'subcategory:id,sub_category_name')
                ->whereHas('user_property', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->when($search, function ($query) use ($search) {
                    $query->where('property_name', 'like', '%' . $search . '%');
                })
                ->paginate(30);
        }

        return view('backend.ManageProducts.main', compact('products'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Categories = Categories::orderBy('created_at', 'desc')->select('id', 'category_name')
            ->where('created_by', Auth::id())
            ->get();
        $subCategories = SubCategories::orderBy('created_at', 'desc')->select('id', 'sub_category_name')
            ->where('created_by', Auth::id())
            ->get();
        return view('backend.ManageProducts.create', compact('Categories', 'subCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */



    /*************  ✨ Codeium Command ⭐  *************/
    /**
     * Store a newly created property in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /******  993c756c-3587-4dd6-a2c1-b96803f1cad7  *******/
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'sub_category_id' => 'required|integer|exists:sub_categories,id',
            'property_name' => 'required|string|max:255',
            'pricing_type' => 'required|string|in:free,paid',
            'pricings' => 'nullable',
            'property_location' => 'required|string',
            'property_quantity' => 'required|integer|min:1',
            'description' => 'required|string',
            'cropped_image' => 'nullable|string',
            'thumbnail' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Process the pricing data
        $pricings = [];
        if ($request->filled('pricings')) {
            $pricings = json_decode($request->input('pricings'), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->withErrors(['pricings' => 'Invalid pricing data']);
            }
        }

        // Save data to the database
        $property = new Propeerty();
        // Handle base64 cropped image and convert to JPG
        if ($request->filled('cropped_image')) {
            $croppedImage = $request->input('cropped_image');
            $croppedImageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $croppedImage));
            $image = Image::make($croppedImageData)->encode('jpg', 100); // Convert to JPG with 90% quality
            $croppedImagePath = 'properties/cropped_' . uniqid() . '.jpg';
            Storage::disk('public')->put($croppedImagePath, $image);
            $property->property_image = $croppedImagePath;

        } elseif ($request->hasFile('thumbnail')) {
            $thumbnail = Image::make($request->file('thumbnail')->getRealPath())
                ->encode('jpg', 90); // Convert to JPG with 90% quality
            $thumbnailPath = 'properties/thumbnail_' . uniqid() . '.jpg';
            Storage::disk('public')->put($thumbnailPath, $thumbnail);

            $property->property_image = $thumbnailPath;

        }
        $property->category_id = $validatedData['category_id'];
        $property->sub_category_id = $validatedData['sub_category_id'];
        $property->property_name = $validatedData['property_name'];
        $property->property_location = $validatedData['property_location'];
        $property->property_quantity = $validatedData['property_quantity'];
        $property->property_description = $validatedData['description'];
        $property->pricing_type = $validatedData['pricing_type'];
        $property->created_by = auth()->user()->id;

        if ($validatedData['pricing_type'] === 'paid') {
            $property->property_price = $pricings[0]['normal_price'];
            $property->property_discount = $pricings[0]['sell_price'];
        }
        $property->property_sell_price = $pricings[0]['normal_price'] - $pricings[0]['sell_price'];

        $property->save();

        $userproperties = Users_Property::create([
            'property_id' => $property->id,
            'user_id' => auth()->user()->id
        ]);
        // Redirect with a success message
        return redirect()->route('products.index')->with('success', 'Property created successfully!');
    }




    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $Categories = Categories::orderBy('created_at', 'desc')->select('id', 'category_name')
            ->where('created_by', Auth::id())
            ->get();
        $subCategories = SubCategories::orderBy('created_at', 'desc')->select('id', 'sub_category_name')
            ->where('created_by', Auth::id())
            ->get();
        $product = Propeerty::findOrFail($id);
        return view('backend.ManageProducts.view', compact('product', 'Categories', 'subCategories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $Categories = Categories::orderBy('created_at', 'desc')->select('id', 'category_name')
            ->where('created_by', Auth::id())
            ->get();
        $subCategories = SubCategories::orderBy('created_at', 'desc')->select('id', 'sub_category_name')
            ->where('created_by', Auth::id())
            ->get();
        $product = Propeerty::with
        ('category:id,category_name', 'subcategory:id,sub_category_name')->findOrFail($id);

        return view('backend.ManageProducts.create', compact('Categories', 'subCategories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'property_name' => 'required|string|max:255',
            'pricing_type' => 'required|string|in:free,paid',
            'pricings' => 'nullable',
            'property_location' => 'required|string',
            'property_quantity' => 'required|integer|min:1',
            'description' => 'required|string',
            'cropped_image' => 'nullable|string',
            'thumbnail' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Find the property
        $property = Propeerty::findOrFail($id);

        // Process the pricing data
        $pricings = [];
        if ($request->filled('pricings')) {
            $pricings = json_decode($request->input('pricings'), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->withErrors(['pricings' => 'Invalid pricing data']);
            }
        }

        // Handle image updates
        if ($request->filled('cropped_image')) {
            // Delete the old image if exists
            if ($property->property_image && Storage::disk('public')->exists($property->property_image)) {
                Storage::disk('public')->delete($property->property_image);
            }

            // Handle base64 cropped image and convert to JPG
            $croppedImage = $request->input('cropped_image');
            $croppedImageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $croppedImage));
            $image = Image::make($croppedImageData)->encode('jpg', 100);
            $croppedImagePath = 'properties/cropped_' . uniqid() . '.jpg';
            Storage::disk('public')->put($croppedImagePath, $image);
            $property->property_image = $croppedImagePath;
        } elseif ($request->hasFile('thumbnail')) {
            // Delete the old image if exists
            if ($property->property_image && Storage::disk('public')->exists($property->property_image)) {
                Storage::disk('public')->delete($property->property_image);
            }

            $thumbnail = Image::make($request->file('thumbnail')->getRealPath())
                ->encode('jpg', 90); // Convert to JPG with 90% quality
            $thumbnailPath = 'properties/thumbnail_' . uniqid() . '.jpg';
            Storage::disk('public')->put($thumbnailPath, $thumbnail);

            $property->property_image = $thumbnailPath;
        }

        // Update other fields
        $property->category_id = $validatedData['category_id'];
        $property->sub_category_id = $validatedData['sub_category_id'];
        $property->property_name = $validatedData['property_name'];
        $property->property_location = $validatedData['property_location'];
        $property->property_quantity = $validatedData['property_quantity'];
        $property->property_description = $validatedData['description'];
        $property->pricing_type = $validatedData['pricing_type'];
        $property->created_by = auth()->user()->id;

        if ($validatedData['pricing_type'] === 'paid' && !empty($pricings)) {
            $property->property_price = $pricings[0]['normal_price'];
            $property->property_discount = $pricings[0]['sell_price'];
            $property->property_sell_price = $pricings[0]['normal_price'] - $pricings[0]['sell_price'];
        } elseif ($validatedData['pricing_type'] === 'free') {
            // Reset pricing details for free items
            $property->property_price = 0;
            $property->property_discount = 0;
            $property->property_sell_price = 0;
        }

        $property->save();

        // Update or create associated user property (if applicable)
        $userProperty = Users_Property::updateOrCreate(
            ['property_id' => $property->id],
            ['user_id' => auth()->user()->id]
        );

        // Redirect with a success message
        return redirect()->route('products.index')->with('success', 'Property updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        try {
            $property = Propeerty::onlyTrashed()->findorFail($id);

            if ($property->property_image && Storage::disk('public')->exists($property->property_image)) {
                Storage::disk('public')->delete($property->property_image);
            }
            $property->delete();
            return redirect()->route('products.index')->with('success', 'Property deleted successfully!');
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
            $blog = Propeerty::findOrFail($id);

            // Update the publish status
            $blog->property_publish_status = $request->publish_status;
            $blog->save();



            return redirect()->route('products.index')->with('success', 'Property published successfully.');

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
            $blog = Propeerty::find($id);
            $blog->property_publish_status = $request->publish_status;
            $blog->save();

            return redirect()->route('products.index', $blog->id)->with('success', 'Property unpublished successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function trashDelete(Request $request, $id)
    {
        try {
            $blog = Propeerty::find($id);
            $blog->delete();

            return redirect()->route('products.index')->with('success', 'Property moved to trash successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function trashView(Request $request)
    {
        $search = $request->input('search');
        $userRole = Auth::user()->role->role_name;
        $userId = Auth::id(); // Get the authenticated user's ID

        if ($userRole == 'Admin') {
            $blogs_trash = Propeerty::onlyTrashed()
                ->with('category:id,category_name', 'subcategory:id,sub_category_name')
                ->whereHas('user_property', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->when($search, function ($query) use ($search) {
                    $query->where('property_name', 'like', '%' . $search . '%');
                })
                ->orderBy('created_at', 'desc')
                ->paginate(30);
        }

        return view('Backend.ManageProducts.trash_view', compact('blogs_trash'));
    }


    public function restore(Request $request, $id)
    {
        try {
            $blog = Propeerty::onlyTrashed()->find($id);
            $blog->restore();

            return redirect()->route('products.index')->with('success', 'Property restored successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function message_store(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'message' => 'nullable|string',
            'property_id' => 'required|exists:propeerties,id',
            'user_id' => 'required|exists:users,id',
            'full_name' => 'required|string|max:255',
            'email_address' => 'required|email|max:255',
            'phone_number' => 'required|string|max:15',
            'subject' => 'required|string|max:255',
        ]);

        // Get the user and property data based on their IDs
        $user = User::find($request->user_id);
        $property = Propeerty::find($request->property_id);

        // Ensure the user and property exist
        if (!$user || !$property) {
            return redirect()->back()->with('error', 'User or Property not found');
        }

        // Create a new property message
        $message = PropertyMessage::create([
            'property_id' => $request->property_id,
            'user_id' => $request->user_id,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        // Prepare the login route (or wherever the user needs to go)
        $loginRoute = route('login');  // This could be a link to the login page or dashboard

        // Send the email notification to the user
        Mail::to($user->email)->send(new PropertyMessageMail($message, $user->name, $property->property_name, $request->subject, $request->message, $loginRoute));

        // Redirect with success message
        return redirect()->back()->with('success', 'Message sent successfully.');
    }
    




}
