<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShippingAddressApiController extends Controller
{
    /**
     * Get all shipping addresses for the authenticated user.
     */
    public function index()
    {
        $addresses = ShippingAddress::where('user_id', Auth::id())->get();
        return response()->json(['addresses' => $addresses], 200);
    }

    /**
     * Store a newly created shipping address.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'address_line1' => 'required|string',
            'address_line2' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'nullable|string',
            'country' => 'required|string',
            'phone_number' => 'required|string',
            'zip_code' => 'nullable|string',
            'google_map_link' => 'nullable|url',
        ]);

        $address = ShippingAddress::create([
            'user_id' => Auth::id(),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address_line1' => $request->address_line1,
            'address_line2' => $request->address_line2,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'phone_number' => $request->phone_number,
            'zip_code' => $request->zip_code,
            'google_map_link' => $request->google_map_link,
        ]);

        return response()->json([
            'message' => 'Shipping address created successfully.',
            'address' => $address
        ], 201);
    }

    /**
     * Get a specific shipping address.
     */
    public function show($id)
    {
        $address = ShippingAddress::where('user_id', Auth::id())->findOrFail($id);
        return response()->json(['address' => $address], 200);
    }

    /**
     * Update an existing shipping address.
     */
    public function update(Request $request, $id)
    {
        $address = ShippingAddress::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'address_line1' => 'required|string',
            'address_line2' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'nullable|string',
            'country' => 'required|string',
            'phone_number' => 'required|string',
            'zip_code' => 'nullable|string',
            'google_map_link' => 'nullable|url',
        ]);

        $address->update($request->all());

        return response()->json([
            'message' => 'Shipping address updated successfully.',
            'address' => $address
        ], 200);
    }

    /**
     * Delete a shipping address.
     */
    public function destroy($id)
    {
        $address = ShippingAddress::where('user_id', Auth::id())->findOrFail($id);
        $address->delete();

        return response()->json(['message' => 'Shipping address deleted successfully.'], 200);
    }
}
