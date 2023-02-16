<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Traits\Response;

class OrderController extends Controller
{
    use Response;
    public function create(Request $request)
    {
        $user = $request->user;
        $course = $request->course;
        $data = Order::create([
            'user_id' => $user['id'],
            'course_id' => $course['id'],
        ]);
        $transactionDetail = [
            'order_id'=>$data->id,
            'gross_amount'=>$course['price'],
        ];
        $itemDetails = [
            [
                'id'=>$course['id'],
                'price'=>$course['price'],
                'quantity'=>1,
                'name'=>$course['name'],
                'brand'=>'BWA',
                'category'=>'Onlinecourse',

            ]
        ];
        $customerDetail = [
            'firstname' => $user['name'],
            'email' => $user['email']
        ];

        $midtransParams = [
            'transaction_details' => $transactionDetail,
            'item_details' => $itemDetails,
            'customer_details' => $customerDetail,

        ];

        $midtransSnapurl = $this->getMidtransSnapurl($midtransParams);
        $data->snap_url = $midtransSnapurl;
        $data->metadata = [
            'course_id' =>$course['id'],
            'course_price' =>$course['price'],
            'course_name'=>$course['name'],
            'course_thumbnail' => 'test',
            'course_level'=> 'test'
        ];
        $data->save();
        return $this->successResponse($data, 'List Chapter');
    }
    private function getMidtransSnapurl($params){

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = env('MIDTRANS_SK');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = (bool) env('MIDTRANS_PRODUCTION');
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = (bool) env('MIDTRANS_3DS');
        
        $snapUrl = \Midtrans\Snap::createTransaction($params)->redirect_url;
        return $snapUrl;
    }
}
