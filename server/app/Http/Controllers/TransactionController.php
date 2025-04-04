<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\PaymentGatewayService;

class TransactionController extends Controller
{
    public function deposite(Request $request)
    {
        $authHeader = $request->header('Authorization');
        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user_fullname_base64 = substr($authHeader, 7);
        $user_fullname = base64_decode($user_fullname_base64);

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'order_id' => 'required|string',
            'timestamp' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $data = $validator->validated();

        $paymentGateway = new PaymentGatewayService();
        $paymentResult = $paymentGateway->initiatePayment('bank_transfer', [
            'amount' => $data['amount'],
            'order_id' => $data['order_id'],
            'bank' => 'bca' // Default bank, can be modified
        ]);

        $transaction = new Transaction();
        $transaction->amount = $data['amount'];
        $transaction->order_id = $data['order_id'];
        $transaction->timestamp = $data['timestamp'];
        $transaction->user_fullname = $user_fullname;
        $transaction->type = "deposite";

        if ($paymentResult['status'] === 'failed')
        {
            $transaction->status = 2;
        }
        else
        {
            $transaction->status = 1;
        }
        $transaction->gateway_transaction_id = $paymentResult['transaction_id'] ?? "-";
        $transaction->save();

        return response()->json([
            "order_id" => $transaction->order_id,
            "amount" => $transaction->amount,
            "status" => $transaction->status,
        ], $paymentResult['status'] === 'failed' ? 400 : 200);
    }

    public function withdraw(Request $request)
    {
        $authHeader = $request->header('Authorization');
        if (!$authHeader ||!str_starts_with($authHeader, 'Bearer ')) {
            return response()->json([
               'message' => 'Unauthorized'
            ], 401);
        }
        $user_fullname_base64 = substr($authHeader, 7);
        $user_fullname = base64_decode($user_fullname_base64);

        $validator = Validator::make($request->all(), [
            'amount' =>'required|numeric',
            'timestamp' =>'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
               'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $data = $validator->validated();

        $paymentGateway = new PaymentGatewayService();
        $withdrawalResult = $paymentGateway->initiateWithdrawal([
            'reference_id' => substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 16),
            'amount' => $data['amount'],
            'payment_method' => 'bank_transfer'
        ]);


        $transaction = new Transaction();
        $transaction->amount = $data['amount'];
        $transaction->order_id = '-';
        $transaction->timestamp = $data['timestamp'];
        $transaction->type = "withdraw";
        $transaction->user_fullname = $user_fullname;
        if ($withdrawalResult['status'] === 'failed')
        {
            $transaction->status = 2;
        }
        else
        {
            $transaction->status = 1;
        }
        $transaction->gateway_transaction_id = $withdrawalResult['transaction_id'] ?? "-";
        $transaction->save();

        return response()->json([
            "order_id" => $transaction->order_id,
            "amount" => $transaction->amount,
        ], $withdrawalResult['status'] === 'failed' ? 400 : 200);
    }

    public function transactions(Request $request)
    {
        $transactions = Transaction::all();

        return response()->json([
            'transactions' => $transactions
        ], 200);
    }
}
