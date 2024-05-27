<?php

namespace App\Http\Controllers\Api\V1\Deliveryman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryMan;
use Illuminate\Support\Str;
use App\Models\Restaurant;
use App\Models\OrderDetail;

class AuthController extends Controller
{
    public function phone_login(Request $request)
    {
        $request->validate([
            'phone' => 'required',
        ]);
        $token = Str::random(120);

        $data = DeliveryMan::where('phone', $request['phone'])->first();

        if ($data != null) {
            $data->auth_token = $token;
            $data->save();
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Login Successfully',
                    'token' => $token,
                    'data' => $data,
                ],
                200
            );
        } else {
            $user = DeliveryMan::create([
                'phone' => $request->phone,
            ]);
            $user->phone = $request->phone;
            $user->auth_token = $token;
            $user->application_status = 'pending';
            $user->status = 0;
            $user->active = 0;
            $user->current_orders = 0;
            $user->order_count = 0;
            $user->assigned_order_count = 0;
            $user->earning = 0;
            $user->application_status = 'pending';
            $user->save();

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Deliveryman Created Successfully',
                    'token' => $token,
                    'data' => $user,
                ],
                200
            );
        }
    }
    public function mail_login(Request $request)
    {
        $request->validate([
            'email' => 'required',
        ]);
        $token = Str::random(120);

        $data = DeliveryMan::where('email', $request['email'])->first();

        if ($data != null) {
            $data->auth_token = $token;
            $data->save();
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Login Successfully',
                    'token' => $token,
                    'data' => $data,
                ],
                200
            );
        } else {
            $user = DeliveryMan::create([
                'email' => $request->email,
            ]);
            $user->email = $request->email;
            $user->application_status = 'pending';
            $user->status = 0;
            $user->auth_token = $token;
            $user->active = 0;
            $user->current_orders = 0;
            $user->order_count = 0;
            $user->assigned_order_count = 0;
            $user->earning = 0;
            $user->application_status = 'pending';
            $user->save();

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Deliveryman Created Successfully',
                    'token' => $token,
                    'data' => $user,
                ],
                200
            );
        }
    }

    public function check_exitsting_phone(Request $request)
    {
        $request->validate([
            'phone' => 'required',
        ]);

        $data = DeliveryMan::where('phone', $request['phone'])->first();
        if ($data != null) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Success deliveryman found',
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Deliveryman not found',
                ],
                404
            );
        }
    }
    public function check_exitsting_mail(Request $request)
    {
        $request->validate([
            'mail' => 'required',
        ]);

        $data = DeliveryMan::where('mail', $request['mail'])->first();
        if ($data != null) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Success deliveryman found',
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Deliveryman not found',
                ],
                404
            );
        }
    }

    public function getProfile(Request $request)
    {
        $dm = DeliveryMan::with(['rating', 'userinfo', 'dm_shift'])
            ->where(['auth_token' => $request['token']])
            ->first();

        return response()->json(
            [
                'status' => false,
                'message' => 'Deliveryman',
                'data' => $dm,
            ],
            200
        );
    }

    public function getAllVendors()
    {
        $vendors = Restaurant::all();
        return response()->json(
            [
                'status' => true,
                'message' => 'All vendors',
                'data' => $vendors,
            ],
            200
        );
    }

    public function assignOrderToCategorywiseInVendor(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'category' => 'required',
            'vendor_id' => 'required',
        ]);

        $ods = OrderDetail::where([
            ['order_id', '=', $request->order_id],
            ['category', '=', $request->category],
        ])->get();

        if (sizeof($ods)) {
            foreach($ods as $od){
                $od->vendor_id = $request->vendor_id;
                $od->save();
            }
            return response()->json([
                'status'=> true,
                'message'=>"Successflully assign to the vendor"
            ],200);
        } else {
            return response()->json([
                'status'=> false,
                'message'=>"Order not found"
            ],404);
        }
    }
    // public function assignOrderToCategorywiseInVendor(Request $request)
    // {
    //     $request->validate([
    //         'order_id' => 'required',
    //         'category' => 'required',
    //         'vendor_id' => 'required',
    //     ]);

    //     $ods = OrderDetail::where([
    //         ['order_id', '=', $request->order_id],
    //         ['category', '=', $request->category],
    //     ])->get();

    //     if (sizeof($ods)) {
    //         foreach($ods as $od){
    //             $od->vendor_id = $request->vendor_id;
    //             $od->save();
    //         }
    //         return response()->json([
    //             'status'=> true,
    //             'message'=>"Successflully assign to the vendor"
    //         ],200);
    //     } else {
    //         return response()->json([
    //             'status'=> false,
    //             'message'=>"Order not found"
    //         ],404);
    //     }
    // }
}
