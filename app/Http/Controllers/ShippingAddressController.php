<?php

namespace App\Http\Controllers;

use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;

class ShippingAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch the user's shipping addresses
        $addresses = ShippingAddress::where('user_id', Auth::id())->get();
    
        return view('shipping_addresses.index', compact('addresses'));
    }
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to create a shipping address.');
        }

        return view('shipping_addresses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'You must be logged in to create a shipping address.');
    }

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

    ShippingAddress::create([
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
        'user_id' => Auth::id(),
    ]);

    return redirect()->route('shipping_addresses.index')
        ->with('success', 'Shipping address saved!');
}

    /**
     * Display the specified resource.
     */
    public function show(ShippingAddress $shippingAddress)
    {
        //
    }
    public function edit(ShippingAddress $shippingAddress)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to edit a shipping address.');
        }
    
        return view('shipping_addresses.edit', compact('shippingAddress'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShippingAddress $shippingAddress)
    {
        if (Auth::id() !== $shippingAddress->user_id) {
            return redirect()->route('shipping_addresses.index')
                ->with('error', 'Unauthorized action!');
        }
    
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'address_line1' => 'required|string',
            'address_line2' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'nullable|string',
            'country' => 'required|string',
            'phone_number' => 'required|string',
            'zip_code' => 'required|string',
            'google_map_link' => 'nullable|url',
        ]);
    
        $shippingAddress->update($request->all());
    
        return redirect()->route('shipping_addresses.index')
            ->with('success', 'Shipping address updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShippingAddress $shippingAddress)
    {
        if (Auth::id() !== $shippingAddress->user_id) {
            return redirect()->route('shipping_addresses.index')
                ->with('error', 'Unauthorized action!');
        }
    
        $shippingAddress->delete();
    
        return redirect()->route('shipping_addresses.index')
            ->with('success', 'Shipping address deleted!');
    }
}
