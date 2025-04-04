<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use \InvalidArgumentException;

class PaymentGatewayService
{
    protected $baseUrl;
    protected $serverKey;

    public function __construct()
    {
        $this->baseUrl = 'https://api.midtrans.com/v2';
        $this->serverKey = env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-XXXXXXXXXXXXXXXX');
    }

    public function initiatePayment(string $paymentMethod, array $paymentData)
    {
        if ($paymentMethod !== 'bank_transfer') {
            throw new InvalidArgumentException('Invalid payment method');
        }

        $isSuccess = rand(0, 1) === 1;

        if (!$isSuccess) {
            return [
                'status' => 'failed',
                'error_code' => 'PAYMENT_FAILED',
                'error_message' => 'Payment processing failed',
                'transaction_id' => null,
                'payment_method' => $paymentMethod,
                'transaction_details' => [
                    'order_id' => $paymentData['order_id'] ?? uniqid(),
                    'gross_amount' => $paymentData['amount']
                ]
            ];
        }

        return [
            'status' => 'success',
            'transaction_id' => strtoupper(substr($paymentMethod, 0, 2)) . '-' . uniqid(),
            'amount' => $paymentData['amount'],
            'payment_method' => $paymentMethod,
            'transaction_details' => [
                'order_id' => $paymentData['order_id'] ?? uniqid(),
                'gross_amount' => $paymentData['amount']
            ],
            // 'specific_params' => [
            //     'bank_transfer' => [
            //         'bank' => $paymentData['bank'], // e.g., 'bca', 'bni', 'mandiri'
            //     ]
            // ]
        ];
    }

    public function initiateWithdrawal(array $data)
    {
        $isSuccess = rand(0, 1) === 1;

        if (!$isSuccess) {
            return [
                'status' => 'failed',
                'error_code' => 'WITHDRAWAL_FAILED',
                'error_message' => 'Withdrawal processing failed',
                'reference_id' => $data['reference_id'],
                'amount' => $data['amount'],
                'payment_method' => $data['payment_method']
            ];
        }

        return [
            'status' => 'success',
            'reference_id' => $data['reference_id'],
            'amount' => $data['amount'],
            'payment_method' => $data['payment_method'],
            'transaction_id' => 'WDR-' . uniqid(),
            'processed_at' => now()
        ];
    }
    public function getSecretKey()
    {
        return $this->serverKey;
    }
}
