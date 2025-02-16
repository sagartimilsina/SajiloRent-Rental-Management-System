<?php

namespace App\Http\Controllers;

use App\Models\Propeerty;
use Illuminate\Http\Request;
use App\Models\Property_Review;

use Illuminate\Support\Facades\Log;
use function Laravel\Prompts\select;

class PropertyReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    public function showPropertyReviews($propertyId)
    {
        // Fetch reviews for the given property with user and property relationships
        $propertyReviews = Property_Review::with('user', 'property')
            ->where('property_id', $propertyId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Check if no reviews are found
        if ($propertyReviews->isEmpty()) {
            return redirect()->back()->with('error', 'No reviews found for this property.');
        }

        // Fetch the property name for the given propertyId (fixed typo)
        $property = Propeerty::find($propertyId);
        if (!$property) {
            return redirect()->back()->with('error', 'Property not found.');
        }
        $propertyName = $property->property_name;

        // Pass both property reviews and property name to the view
        return view('Backend.Manageproducts.product-comment', compact('propertyReviews', 'propertyName', 'propertyId'));
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
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
            'property_id' => 'required|exists:propeerties,id',
            'user_id' => 'required|exists:users,id',
        ]);

        Property_Review::create([
            'property_id' => $request->property_id,
            'user_id' => $request->user_id,
            'property_rating' => $request->rating,
            'property_review' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Your review has been submitted.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Property_Review $property_Review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property_Review $property_Review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property_Review $property_Review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Fetch the review by ID
        $property_Review = Property_Review::find($id);
        // Check if the review exists
        if ($property_Review) {
            // Delete the review
            $property_Review->delete();
            // Optionally log the deletion action (you can include the user ID if needed)
            Log::info('Review deleted', ['review_id' => $id]);
            return redirect()->back()->with('success', 'Your review has been deleted.');
        }

        // If review not found, log the error and redirect
        Log::warning('Review not found for deletion', ['review_id' => $id]);
        return redirect()->back()->with('error', 'Review not found.');
    }
}
