<?php

namespace App\Http\Controllers;

use App\Jobs\SendOrderToTelegramJob;
use App\Models\Order;
use App\Models\Transaction;
use App\Service\PaymentService;
use Exception;
use Illuminate\Http\Request;
use YooKassa\Model\Notification\NotificationEventType;
use YooKassa\Model\Notification\NotificationSucceeded;
use YooKassa\Model\Notification\NotificationWaitingForCapture;
use YooKassa\Model\Payment\PaymentStatus;

class OrderController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('checkout');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email',
            'address' => 'required|string|max:150',
            'comment' => 'nullable|string|max:500',
        ]);
        $cart = session()->get('cart');
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $order = Order::create([
            ...$validated,
            'total_price' => $total
        ]);

        // Добавляем товары
        foreach ($cart as $productId => $item) {
            $order->items()->create([
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        // Очищаем корзину
        session()->forget('cart');

        $service = new PaymentService;
        $confirmationUrl = $service->createPayment($order);

        return redirect($confirmationUrl);
    }

    public function callback()
    {
        $source = file_get_contents('php://input');
        $requestBody = json_decode($source, true);

        try {

            $notification = ($requestBody['event'] === NotificationEventType::PAYMENT_SUCCEEDED)
                ? new NotificationSucceeded($requestBody)
                : new NotificationWaitingForCapture($requestBody);

            $payment = $notification->getObject();
            if (isset($payment->status) && ($payment->status === 'succeeded')) {
                if ((bool)$payment->paid === true) {
                    $metadata = (object)$payment->metadata;
                    if (isset($metadata->order_id)) {
                        $orderId = (int)$metadata->order_id;
                        $transaction = Transaction::find($orderId);
                        $transaction->status = 'CONFIRMED';
                        $transaction->update([
                            'status' => 'CONFIRMED'
                        ]);
                        dispatch(new SendOrderToTelegramJob($orderId));
                    }
                }
            }
        } catch (Exception $e) {
            // Обработка ошибок при неверных данных
        }
    }
}
