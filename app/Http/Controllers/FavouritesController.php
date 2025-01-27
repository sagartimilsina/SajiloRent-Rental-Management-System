<?php

namespace App\Http\Controllers;

use App\Models\Favourites;
use Illuminate\Http\Request;

class FavouritesController extends Controller
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
            'user_id' => 'required|exists:users,id',
            'property_id' => 'required|exists:propeerties,id',
        ]);

        $userId = $request->user_id;
        $propertyId = $request->property_id;

        $favorite_true = Favourites::where('user_id', $userId)->where('property_id', $propertyId)
            ->where('favourite_status', true)
            ->first();
        $favorite_false = Favourites::where('user_id', $userId)->where('property_id', $propertyId)
            ->where('favourite_status', false)
            ->first();

        if ($favorite_true) {

            // Remove from favorites
            $favorite_true->favourite_status = false;
            $favorite_true->save();

            return response()->json(['success' => true, 'isFavorite' => false]);

        } elseif ($favorite_false) {
            $favorite_false->favourite_status = true;
            $favorite_false->save();
            return response()->json(['success' => true, 'isFavorite' => true]);
        } else {
            // Add to favorites
            Favourites::create([
                'user_id' => $userId,
                'property_id' => $propertyId,
                'favourite_status' => true, // Storing favorite status
            ]);

            return response()->json(['success' => true, 'isFavorite' => true]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Favourites $favourites)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Favourites $favourites)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Favourites $favourites)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Favourites $favourites)
    {
        //
    }
}
