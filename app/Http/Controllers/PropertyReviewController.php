<?php

namespace App\Http\Controllers;

use App\Models\Property_Review;
use Illuminate\Http\Request;

class PropertyReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function destroy(Property_Review $property_Review)
    {
        //
    }
}
