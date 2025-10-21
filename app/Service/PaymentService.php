<?php

namespace App\Service;

use App\Models\Order;
use App\Models\Transaction;
use YooKassa\Client;

class PaymentService
{
    private function getClient()
    {
        $client = new Client();
        $client->setAuth(config('services.yookassa.shop_id'), config('services.yookassa.secret_key'));
        return $client;
    }

    public function createPayment(Order $order)
    {
        $client = $this->getClient();
        $payment = $client->createPayment([
            'amount' => [
                'value' => $order->total_price,
                'currency' => 'RUB',
            ],
            'capture' => true,
            'confirmation' => [
                'type' => 'redirect',
                'return_url' => '/',
            ],
            'description' => 'Оплата заказа №' . $order->id,
            'metadata' => [
                'order_id' => $order->id
            ]
        ], uniqid('', true));

        Transaction::create([
            'order_id' => $order->id,
            'payment_id' => $payment->id,
            'amount' => $order->total_price,
            'payment_method' => $payment->payment_method?->type ?? null,
        ]);
        return $payment->getConfirmation()->getConfirmationUrl();
    }
}
