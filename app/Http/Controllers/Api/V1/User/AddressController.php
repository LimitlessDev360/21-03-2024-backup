<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\User\Address;

class AddressController extends Controller
{
    public function addAddress(Request $request)
    {
        // $data = $request->validate([
        //     'contact_name' => 'required',
        //     'contact_phone' => 'required',
        //     'address' => 'required',
        //     'latitude' => 'required',
        //     'longitude' => 'required',
        //     'address_type' => 'required',
        //     'is_default' => 'required',
        // ]);
        // $user_id = $request->user()->id;

        // $address = Address::create([
        //     'contact_name' => $request->contact_name,
        //     'contact_phone' => $request->contact_phone,
        //     'user_id' => $user_id,
        //     'address' => $request->address,
        //     'latitude' => $request->latitude,
        //     'longitude' => $request->longitude,
        //     'address_type' => $request->address_type,
        //     'is_default' => $request->is_default,
        // ]);
    }
}
