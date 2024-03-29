<?php

namespace App\Http\Controllers\Api\V1\DeliveryMan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Delivery\DeliverymanAmountRequest;
use App\Models\DeliveryMan;

class AmountRequestController extends Controller
{
    public function amountRequest(Request $request)
    {
        //validate
        $data = $request->validate([
            'requested_amount' => 'required',
        ]);

        //create
        // $dm = DeliveryMan::where(['auth_token' => $request['token']])->first();
        // $amountRequest = DeliverymanAmountRequest::create([
        //     'name' => $dm->f_name,
        //     'deiveryman_id' => $dm->id,
        //     'requested_amount' => $data['requested_amount'],
        //     'paid_amount' => $data['paid_amount'],
        //     'remaining_amount' => $data['remaining_amount'],
        //     'status' => 'requested',
        // ]);

        // return response()->json([
        //     'status' => true,
        //     'message' => 'Withdraw requested successfully',
        // ]);
    }
}
