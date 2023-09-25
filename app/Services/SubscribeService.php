<?php

namespace App\Services;

use Exception;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\UserSubscribe;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Client\Request;

class SubscribeService
{








    public function subscribePayment($data, $userId)
    {
        $carts = [];

        foreach ($data['data'] as $item) {
            $status = is_null($item['type']) ? 0 : 1;

            $userSubscribe = UserSubscribe::create([
                'user_id' => $userId,
                'item_id' => $item['item_id'],
                'type' => $item['type'],
                'status' => $status,
                'is_complete' => 1
            ]);

            $cart = Cart::create([
                'user_subscribe_id' => $userSubscribe->id,
                'quantity' => $item['quantity'],
                'buy_date' => $data['buy_date'],
            ]);

            $carts[] = $cart;


        }

        Payment::create([
            'subscribe_user_id' => $userId,
            'amount' => $data['amount'],
            'payment_date' => $data['buy_date'],
            'payment_method' => $data['payment_method'],
        ]);

        return $carts;
    }


}



