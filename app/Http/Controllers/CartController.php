<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Propeerty;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cartItems = Cart::with(['property.subcategory.category', 'user'])
            ->where('user_id', Auth::user()->id)
            ->get();

        $cartCount = $cartItems->count();

        return view('frontend.cart', compact('cartItems', 'cartCount'));
    }

    public function checkout(Request $request)
    {
        $selectedItems = json_decode($request->input('selected_items'), true);

        if (empty($selectedItems)) {
            return redirect()->route('cart.index')->with('error', 'No items selected for checkout.');
        }

        // Extract item IDs and create a mapping of ID to quantity
        $itemIds = array_column($selectedItems, 'id');
        $quantityMap = array_combine(
            array_column($selectedItems, 'id'),
            array_column($selectedItems, 'quantity')
        );

        // Fetch cart items with property relationships
        $cartItems = Cart::with('property.category')->whereIn('id', $itemIds)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'No valid items found for checkout.');
        }

        // Calculate subtotal with individual item quantities
        $subtotal = 0;
        $cartItems->each(function ($item) use (&$subtotal, $quantityMap) {
            $quantity = $quantityMap[$item->id] ?? 1;
            $item->property_quantity = $quantity; // Set quantity for the view
            $subtotal += $item->property->property_sell_price * $quantity;
        });
        $total = $subtotal;
        $tax = $subtotal * 0.13;

        return view('frontend.checkout_page', compact('cartItems', 'subtotal', 'total', 'tax'));
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
        try {

            $request->validate([
                'property_id' => 'required|exists:propeerties,id', // Fix typo if "properties"
                'user_id' => 'required|exists:users,id',
            ]);

            // Find the user
            $user = User::findOrFail($request->user_id);

            // Find the property
            $propertyId = $request->input('property_id');
            $property = Propeerty::findOrFail($propertyId); // Fix typo if "Propeerty"

            // Check if the property is already in the user's cart
            $existingItem = Cart::where('user_id', $user->id)
                ->where('property_id', $propertyId)
                ->first();

            if ($existingItem) {
                return redirect()->back()->with('error', 'Property is already in the cart.');
            }

            // Add the property to the cart
            $cartItem = new Cart();
            $cartItem->user_id = $user->id;
            $cartItem->property_id = $propertyId;
            $cartItem->property_quantity = 1; // Default quantity
            $cartItem->save();

            // Redirect to cart index or another page
            return redirect()->route('cart.index')->with('success', 'Property added to cart successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Catch errors if the user or property is not found
            return redirect()->back()->with('error', 'User or property not found.');
        } catch (\Exception $e) {
            // Catch any other exceptions
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            Log::info('property_id: ' . $id);
            $cartItem = Cart::where('id', $id)->where('user_id', auth()->id())->first();

            Log::info('cartItem: ' . $cartItem);

            if (!$cartItem) {
                return response()->json(['success' => false, 'message' => 'Item not found'], 404);
            }

            $cartItem->delete();

            return response()->json(['success' => true, 'message' => 'Item removed from cart']);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error deleting cart item: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong'], 500);
        }
    }

}
