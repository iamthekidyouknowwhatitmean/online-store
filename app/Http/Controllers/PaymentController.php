<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Service\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function create(Order $order, PaymentService $service)
    {
        $confirmationUrl = $service->createPayment($order);

        return redirect($confirmationUrl);
    }
}
