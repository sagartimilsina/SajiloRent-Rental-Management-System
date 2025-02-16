<?php

namespace App\Http\Controllers\Frontend;

use App\Models\FAQ;

use App\Models\User;
use App\Models\Blogs;
use App\Models\Teams;

use App\Models\Abouts;
use App\Models\Gallery;
use App\Models\Propeerty;
use App\Models\Categories;
use App\Models\Favourites;

use App\Models\SliderImages;
use App\Models\Testimonials;
use Illuminate\Http\Request;
use App\Models\SubCategories;
use App\Models\Property_Review;
use App\Models\Achievement;

use App\Models\Request_owner_lists;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;

class FrontendController extends Controller
{
    public function index()
    {
        $Sliders = SliderImages::where('slider_publish_status', 1)->orderBy('created_at', 'desc')->get();

        $categories = Categories::where('publish_status', 1)->orderBy('created_at', 'desc')->get();
        $abouts = Abouts::where('about_publish_status', 1)->get();
        $favoriteIds = [];
        if (Auth::check()) {
            $favoriteIds = Favourites::where('user_id', Auth::id())
                ->where('favourite_status', true)
                ->pluck('property_id')
                ->toArray();
        }


        $abouts = Abouts::where('about_publish_status', 1)->get();
        $favoriteIds = [];
        if (Auth::check()) {
            $favoriteIds = Favourites::where('user_id', Auth::id())
                ->where('favourite_status', true)
                ->pluck('property_id')
                ->toArray();
        }

        $apartments = Propeerty::where('property_publish_status', 1)->orderBy('created_at', 'desc')->take(8)->get();
        $galleries = Gallery::where('gallery_publish_status', 1)->orderBy('created_at', 'desc')
            ->where('gallery_type', 'image')
            ->take(6)->get();
        $testimonials = Testimonials::where('testimonials_publish_status', 1)->get();
        $blogs = Blogs::where('blog_publish_status', 1)->orderBy('created_at', 'desc')->take(8)->get();
        $achievements = Achievement::all();


        return view('frontend.index', compact('Sliders', 'categories','achievements', 'abouts', 'apartments', 'galleries', 'testimonials', 'blogs', 'favoriteIds'));
    }
    // In your Controller
    public function getSubcategories($id)
    {
        $subcategories = SubCategories::where('category_id', $id)->get();
        return response()->json($subcategories);
    }

    // public function product_filter($categoryId)
    // {
    //     $properties = Propeerty::where('property_publish_status', 1)
    //         ->where('category_id', $categoryId)
    //         ->orderBy('created_at', 'desc')
    //         ->paginate(30);

    //     $categories = Categories::orderBy('created_at', 'desc')
    //         ->where('publish_status', 1)
    //         ->get();


    //     return view('frontend.product', compact('properties', 'categories'));
    // }

    public function dynamic($id)
    {
        // Fetch the 'Abouts' entry based on the given ID and its publish status
        $about = Abouts::where('id', $id)
            ->where('about_publish_status', 1) // Check for published status
            ->first();

        // Return or handle the `$about` object
        if ($about) {
            return view('frontend.about_dynamic', ['about' => $about]);
        } else {
            return redirect()->route('about')->with('error', 'Content not found or unpublished.');
        }
    }



    public function about()
    {
        $about = Abouts::where('about_publish_status', 1)
            ->where('head', 'About Us')

            ->first();

        $faqs = FAQ::orderBy('created_at', 'desc')->where('faq_publish_status', 1)->get();

        $testimonials = Testimonials::orderBy('created_at', 'desc')->where('testimonials_publish_status', 1)->get();
        $teams = Teams::orderBy('created_at', 'desc')->where('team_publish_status', 1)->get();
        return view('frontend.about', compact('about', 'faqs', 'testimonials', 'teams'));
        $about = Abouts::where('about_publish_status', 1)
            ->where('head', 'About Us')

            ->first();

        $faqs = FAQ::orderBy('created_at', 'desc')->where('faq_publish_status', 1)->get();

        $testimonials = Testimonials::orderBy('created_at', 'desc')->where('testimonials_publish_status', 1)->get();
        $teams = Teams::orderBy('created_at', 'desc')->where('team_publish_status', 1)->get();
        return view('frontend.about', compact('about', 'faqs', 'testimonials', 'teams'));
    }
    public function blog()
    {
        $blogs = Blogs::where('blog_publish_status', 1)->orderBy('created_at', 'desc')->get();
        return view('frontend.blog', compact('blogs'));
    }
    public function blog_details($id)
    {
        $blog = Blogs::findOrFail($id);
        $similar_blogs = Blogs::where('blog_publish_status', 1)->where('id', '!=', $id)->orderBy('created_at', 'desc')->take(8)->get();
        return view('frontend.blog_detail', compact('blog', 'similar_blogs'));
    }
    public function contact()
    {
        return view('frontend.contact');
    }
    public function gallery()
    {
        // Fetch 16 images and 4 videos initially
        $gallery_images = Gallery::where('gallery_publish_status', 1)
            ->where('gallery_type', 'image')
            ->orderBy('created_at', 'desc')
            ->paginate(20); // Fetch 16 images per page

        $gallery_videos = Gallery::where('gallery_publish_status', 1)
            ->where('gallery_type', 'video')
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Fetch 4 videos per page

        return view('frontend.gallery', compact('gallery_images', 'gallery_videos'));
    }

    public function property_details($id)
    {
        // Fetch property details with images
        $property = Propeerty::with(['propertyImages' => function ($query) {
            $query->where('property_publish_status', 1);
        }])->findOrFail($id);


        // Debugging: Check if the property is fetched correctly
        if (!$property) {
            return redirect()->back()->with('error', 'Property not found.');
        }

        // Increment the views count for the property
        $property->increment('views_count');
        // Fetch favorite IDs for authenticated users
        $favoriteIds = [];
        if (Auth::check()) {
            $favoriteIds = Favourites::where('user_id', Auth::id())
                ->where('favourite_status', true)
                ->pluck('property_id')
                ->toArray();
        }

        // Fetch property reviews
        $property_review = Property_Review::where('property_id', $id)->get();

        // Fetch similar properties (excluding the current one)
        $similar_properties = Propeerty::where('property_publish_status', 1)
            ->where('id', '!=', $id)
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        // Return the view with data
        return view('frontend.product_details', compact('property', 'similar_properties', 'property_review', 'favoriteIds'));
    }

    public function request()
    {
        return view('frontend.listyourproperty');
    }

    public function submitRequest(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15|unique:users,phone,' . $request->input('user_id'),

            'email_address' => 'required|email|max:255',
            'residential_address' => 'required|string|max:255',
            'national_id' => 'required|string|max:255',
            'govt_id_proof' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'agree_terms' => 'accepted|required',

            // Optional fields
            'business_name' => 'nullable|string|max:255',
            'pan_registration_id' => 'nullable|string|max:255',
            'business_type' => 'nullable|string|max:255',
            'business_proof' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $data = $validated;
        if ($request->agree_terms == 'on') {
            $data['agree_terms'] = true;
        } else {
            $data['agree_terms'] = false;
        }
        if ($request->has('phone_number')) {

            $user_id = $request->input('user_id');
            $phone_number = $request->input('phone_number');
            $user = User::find($user_id);
            if ($user) {
                $user->phone = $phone_number;
                $user->save();
            }
        }
        // Handle the govt_id_proof file upload
        if ($request->hasFile('govt_id_proof')) {
            $gov_id_proof = $request->file('govt_id_proof');
            $gov_id_proof_name = uniqid() . '_' . $gov_id_proof->getClientOriginalName();
            $data['govt_id_proof'] = $gov_id_proof->storeAs('government_id_proof', $gov_id_proof_name, 'public');
        }

        // Handle the business_proof file upload
        if ($request->hasFile('business_proof')) {
            $business_proof = $request->file('business_proof');
            $business_proof_name = uniqid() . '_' . $business_proof->getClientOriginalName();
            $data['business_proof'] = $business_proof->storeAs('business_proofs', $business_proof_name, 'public');
        }

        try {
            // Save the data to the database
            $requestRecord = Request_owner_lists::create($data);

            // Notify Super Admin via email
            Mail::send('emails.Request_Owner.property_request_admin', ['data' => $data], function ($message) use ($data) {
                $message->to('timilsinasagar04@gmail.com', 'Super Admin')
                    ->subject('New Property Request Received')
                    ->from('timilsinasagar04@gmail.com', 'Sajilo Rent Team')
                    ->replyTo($data['email_address'], $data['full_name']);
            });

            // Notify User via email
            Mail::send('emails.Request_Owner.property_request_user', ['data' => $data], function ($message) use ($data) {
                $message->to($data['email_address'], $data['full_name'])->subject('Your Property Request Submission');
                $message->from('timilsinasagar04@gmail.com', 'Sajilo Rent Team');
            });

            // Redirect back with success message
            return redirect()->route('index')->with('success', 'Your request has been submitted successfully!');
        } catch (\Exception $e) {
            // Log the error and show the error message
            Log::error('Error submitting property request: ' . $e->getMessage());
            return redirect()->back()->withErrors(['An error occurred while processing your request. Please try again.']);
        }
    }

    public function product_or_property()
    {
        // Fetch all categories with their subcategories
        $categories = Categories::with('subcategories')->get();

        // Fetch all properties (or apply filters if needed)
        $properties = Propeerty::with(['category', 'subcategory'])->paginate(20);

        // Fetch favorite IDs for authenticated users
        $favoriteIds = [];
        if (Auth::check()) {
            $favoriteIds = Favourites::where('user_id', Auth::id())
                ->where('favourite_status', true)
                ->pluck('property_id')
                ->toArray();
        }

        return view('frontend.product', compact('categories', 'properties', 'favoriteIds'));
    }



    /**
     * Filter properties based on category or subcategory.
     */
    public function filter(Request $request)
    {
        $categoryId = $request->input('category_id');
        $subCategoryId = $request->input('sub_category_id');
        $filter = $request->input('filter');

        // Query properties based on filters
        $properties = Propeerty::query();

        if ($categoryId) {
            $properties->where('category_id', $categoryId);
        }

        if ($subCategoryId) {
            $properties->where('sub_category_id', $subCategoryId);
        }

        // Apply additional filters
        if ($filter) {
            switch ($filter) {
                case 'popular':
                    $properties->orderBy('views_count', 'desc');
                    break;
                case 'date-new':
                    $properties->orderBy('created_at', 'desc');
                    break;
                case 'date-old':
                    $properties->orderBy('created_at', 'asc');
                    break;
                case 'price-low':
                    $properties->orderBy('property_sell_price', 'asc');
                    break;
                case 'price-high':
                    $properties->orderBy('property_sell_price', 'desc');
                    break;
                default:
                    // No additional filter
                    break;
            }
        }

        $properties = $properties->with(['category', 'subcategory'])->paginate(20);

        // Fetch favorite IDs for authenticated users
        $favoriteIds = [];
        if (Auth::check()) {
            $favoriteIds = Favourites::where('user_id', Auth::id())
                ->where('favourite_status', true)
                ->pluck('property_id')
                ->toArray();
        }

        // Return the filtered properties as JSON (for AJAX requests)
        if ($request->ajax()) {
            return response()->json([
                'properties' => view('frontend.property.partials.property_list', compact('properties', 'favoriteIds'))->render(),
                'pagination' => $properties->links()->toHtml(),
            ]);
        }

        // For non-AJAX requests, return the full view
        $categories = Categories::with('subcategories')->get(); // Fetch categories for the view
        return view('frontend.product', compact('categories', 'properties', 'favoriteIds'));
    }


    public function search(Request $request)
    {
        $request->validate([
            'location' => 'nullable|string',
            'category_id' => 'required|exists:categories,id', // Ensure this matches the form field name
            'sub_category_id' => 'required|exists:sub_categories,id', // Ensure this matches the form field name
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
        ]);

        // Additional validation for price range
        if ($request->has('min_price') && $request->has('max_price')) {
            $request->validate([
                'max_price' => 'gte:min_price',
            ]);
        }

        // Get the search parameters from the request
        $location = $request->input('location');
        $categoryId = $request->input('category_id');
        $subCategoryId = $request->input('sub_category_id');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        // Start building the query
        $query = Propeerty::query();

        // Apply location filter
        if ($location) {
            $query->where('property_location', 'like', '%' . $location . '%');
        }

        // Apply category filter
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        // Apply subcategory filter
        if ($subCategoryId) {
            $query->where('sub_category_id', $subCategoryId);
        }

        // Apply price range filter
        if ($minPrice && $maxPrice) {
            $query->whereBetween('property_sell_price', [$minPrice, $maxPrice]);
        } elseif ($minPrice) {
            $query->where('property_sell_price', '>=', $minPrice);
        } elseif ($maxPrice) {
            $query->where('property_sell_price', '<=', $maxPrice);
        }

        // Fetch the filtered properties
        $properties = $query->with(['category', 'subcategory'])->paginate(10);

        // Fetch favorite IDs for authenticated users
        $favoriteIds = [];
        if (Auth::check()) {
            $favoriteIds = Favourites::where('user_id', Auth::id())
                ->where('favourite_status', true)
                ->pluck('property_id')
                ->toArray();
        }
        // Fetch all categories with their subcategories
        $categories = Categories::with('subcategories')->get();



        // Fetch favorite IDs for authenticated users
        $favoriteIds = [];
        if (Auth::check()) {
            $favoriteIds = Favourites::where('user_id', Auth::id())
                ->where('favourite_status', true)
                ->pluck('property_id')
                ->toArray();
        }

        // Return the view with the filtered properties
        return view('frontend.product', compact('properties', 'favoriteIds', 'categories'));
    }
}
