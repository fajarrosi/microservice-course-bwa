<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\Response;
use App\Order;
use App\PaymentLog;

class WebhookController extends Controller
{
    use Response;
    public function midtransHandler(Request $request)
    {
        $data = $request->all();
        $signatureKey = $data['signature_key'];
        $orderId = $data['order_id'];
        $statusCode = $data['status_code'];
        $grossAmount = $data['gross_amount'];
        $transactionStatus = $data['transaction_status'];
        $paymentType = $data['payment_type'];
        $fraudStatus = $data['fraud_status'];
        $serverKey =  env('MIDTRANS_SK');

        $mySignatureKey = hash('sha512',$orderId.$statusCode.$grossAmount.$serverKey);

        if($signatureKey !== $mySignatureKey){
            return $this->errorResponse(null, 'Invalid Signature',400);
        }
        $realOrderId = explode('-',$orderId)[0];
        $order = Order::find($realOrderId);

        if(!$order){
            return $this->errorResponse(null, 'Order ID Not Found',404);
        }
        
        if($order->status === 'success'){
            return $this->errorResponse(null, 'Operation not permitter',405);
        }

        if ($transactionStatus == 'capture'){
            if ($fraudStatus == 'challenge'){
                $order->status ='challenge';
            } else if ($fraudStatus == 'accept'){
                $order->status ='success';
            }
        } else if ($transactionStatus == 'settlement'){
            $order->status ='success';
        } else if ($transactionStatus == 'cancel' ||
            $transactionStatus == 'deny' ||
            $transactionStatus == 'expire'){
            $order->status ='failure';
        } else if ($transactionStatus == 'pending'){
            $order->status ='pending';
        }

        $order->save();

        $logsData = [
            'status'=>$transactionStatus,
            'payment_type'=>$paymentType,
            'raw_response'=>json_encode($data),
            'order_id'=>$realOrderId,
        ];

        PaymentLog::create($logsData);

        if ($order->status === 'success') {
            //
        }
        return $this->successResponse(null, 'List Order');



    }
}
