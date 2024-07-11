<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $type = 110;
        $billingType = 120;

        $address = Address::where('user_id', $user->id)->where('type', $type)->first();
        $billingAddress = Address::where('user_id', $user->id)->where('type', $billingType)->first();

        return view('profile.edit', compact('address', 'billingAddress'));
    }
    public function addAddress(Request $request)
    {
        $user = auth()->user();
        $type = 110;

        $address = Address::where('user_id', $user->id)->where('type', $type)->first();

        $data = $request->all();
        $data['type'] = $type;
        $data['user_id'] = $user->id;

        if ($address) {
            $address->update($data);
        } else {
            Address::create($data);
        }


        return redirect()->route('profile.edit')->with('status', 'address-updated');
    }

    public function addBillingAddress(Request $request)
    {
        $user = auth()->user();
        $type = 120;

        $address = Address::where('user_id', $user->id)->where('type', $type)->first();

        $data = $request->all();
        $data['type'] = $type;
        $data['user_id'] = $user->id;

        if ($address) {
            $address->update($data);
        } else {
            Address::create($data);
        }


        return redirect()->route('profile.edit')->with('status', 'address-updated');
    }
}
