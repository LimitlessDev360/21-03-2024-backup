<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Food;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;
use App\CentralLogics\Helpers;

class OrderController extends Controller
{
    public function place_order(Request $request)
    {
        // validate
        $request->validate([
            'order_amount' => 'required',
            'payment_method' =>
                'required|in:cash_on_delivery,digital_payment,wallet,offline_payment',
            'order_type' => 'required|in:take_away,delivery',
            'restaurant_id' => '',
            'lankmark' => '',
            'distance' => 'required',
            'address' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
            'dm_tips' => 'nullable',
            'contact_person_name' => 'required',
            'contact_person_number' => 'required',
            'preferred_time' => 'required',
            'preferred_date' => 'required',
            // 'items' => 'required',
        ]);

        $address = [
            'name' => $request->address,
            'lankmark' => $request->lankmark,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'contact_name' => $request->user()->f_name,
            'phone' => $request->user()->phone,
        ];

        ///create order
        $order = new Order();
        $order->id = 100000 + Order::count() + 1;
        if (Order::find($order->id)) {
            $order->id = Order::orderBy('id', 'desc')->first()->id + 1;
        }

        $order->user_id = $request->user()->id;
        $order->distance = $request['distance'];
        $order->order_amount = $request['order_amount'];
        $order->payment_status = $request->partial_payment
            ? 'partially_paid'
            : ($request['payment_method'] == 'wallet'
                ? 'paid'
                : 'unpaid');
        $order->order_status = 'pending';
        $order->coupon_code = $request['coupon_code'];
        $order->payment_method = $request->partial_payment
            ? 'partial_payment'
            : $request->payment_method;
        $order->cutting_instruction = $request->cutting_instruction;
        $order->order_type = $request['order_type'];
        $order->restaurant_id = $request['restaurant_id'];
        $order->delivery_charge = $request->delivery_charge;
        $order->delivery_address = json_encode($address);
        $order->schedule_at = $request->schedule_at;
        $order->scheduled = $request->schedule_at ? 1 : 0;
        $order->preferred_time = $request->preferred_time;
        $order->preferred_date = $request->preferred_date;
        $order->otp = rand(1000, 9999);
        $order->created_at = now();
        $order->updated_at = now();
        $order->delivery_instruction = $request->delivery_instruction;
        // $order->save();
        // return "Success";

        /// cart data
        $carts = Cart::where('user_id', $order->user_id)
            ->when($request->cart_id, function ($query) use ($request) {
                return $query->where('id', $request->cart_id);
            })
            ->get();
        foreach ($carts as $c) {
            if (
                $c['item_type'] === 'App\Models\ItemCampaign' ||
                $c['item_type'] === 'AppModelsItemCampaign'
            ) {
                $product = ItemCampaign::active()->find($c['item_id']);
                $campaign_id = $c['item_id'];
                $code = 'campaign';
            } else {
                $product = Food::active()->find($c['item_id']);
                $food_id = $c['item_id'];
                $code = 'food';
            }

            $or_d = [
                'food_id' => $food_id ?? null,
                'item_campaign_id' => $campaign_id ?? null,
                'food_details' => json_encode($product),
                'quantity' => $c['quantity'],
                'price' => $c['price'],
                'portion' => $c['portion'],
                'category' => $c['category'],
                'tax_amount' => '0',
                'discount_on_food' => '0',
                'discount_type' => 'discount_on_product',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $order_details[] = $or_d;
        }

        try {
            DB::beginTransaction();

            $order->save();

            foreach ($order_details as $key => $item) {
                $order_details[$key]['order_id'] = $order->id;
            }

            OrderDetail::insert($order_details);

            foreach ($carts as $cart) {
                $cart->delete();
            }

            DB::commit();

            return response()->json(
                [
                    'message' => translate(
                        'messages.order_placed_successfully'
                    ),
                    'order_id' => $order->id,
                ],
                200
            );
        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json([$e->getMessage()], 403);
        }

        return response()->json(
            [
                'code' => 'order_time',
                'message' => translate('messages.failed_to_place_order'),
            ],

            403
        );
    }

    public function orderList(Request $request)
    {
        $user_id = $request->user()->id;
        $paginator = Order::with('details')
            ->where(['user_id' => $user_id])
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Order get successfully',
            'data' => $paginator,
        ]);
    }
    public function runningOrders(Request $request)
    {
        $user_id = $request->user()->id;
        $paginator = Order::with(['details','delivery_man'])
            ->where(['user_id' => $user_id])
            ->whereNotIn('order_status', [
                'delivered',
                'canceled',
                'refund_requested',
                'refund_request_canceled',
                'refunded',
                'failed',
            ])
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Running orders get successfully',
            'data' => $paginator,
        ]);
    }

    public function cancelOrder(Request $request){
        $request->validate([
            'order_id' => 'required',
            'reason' => 'required',
        ]);

        $user_id = $request->user()->id;
        $order = Order::where(['user_id' => $user_id, 'id' => $request['order_id']])->first();
        if(!$order){
            return response()->json([
                'status' => false,
                'message' => 'Order not found',
            ],404);
        }
        else if ($order->order_status == 'pending' || $order->order_status == 'failed' || $order->order_status == 'canceled'  ) {
            $order->order_status = 'canceled';
            $order->canceled = now();
            $order->cancellation_reason = $request->reason;
            $order->canceled_by = 'customer';
            $order->save();



            // $wallet_status= BusinessSetting::where('key','wallet_status')->first()?->value;
            // $refund_to_wallet= BusinessSetting::where('key', 'wallet_add_refund')->first()?->value;

            // if($order?->payments && $order?->is_guest == 0){
            //     $refund_amount =$order->payments()->where('payment_status','paid')->sum('amount');
            //     if($wallet_status &&  $refund_to_wallet && $refund_amount > 0){
            //         CustomerLogic::create_wallet_transaction(user_id:$order->user_id, amount:$refund_amount,transaction_type: 'order_refund',referance: $order->id);

            //         return response()->json(['message' => translate('messages.order_canceled_successfully_and_refunded_to_wallet')], 200);
            //     } else {
            //         return response()->json(['message' => translate('messages.order_canceled_successfully_and_for_refund_amount_contact_admin')], 200);
            //     }
            // }
            return response()->json([
                'status' => true,
                'message' => 'Order canceled successfully',
            ]);

        }
        return response()->json([
            'status' => false,
            'message' => 'You cannot cancel after confirm',
        ],403);

    }


    public function removeCart(Request $request){
        $request->validate([
            'id' => 'required',
        ]);

        $user_id = $request->user()->id;
    
        $data = Cart::find($request['id']);
        $data->delete();

        $carts = Cart::where('user_id', $user_id)->get()
        ->map(function ($data) {
			$data->item = Helpers::cart_product_data_formatting($data->item, false, app()->getLocale());
            return $data;
		});

        return response()->json([
            'status' => 200,
            'message' => 'Cart Remove Successfully',
            'data' => $carts,
        ]);
    }
}
