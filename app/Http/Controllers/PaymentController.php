<?php

namespace App\Http\Controllers;

use App\Service\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function create(Request $request, PaymentService $service) {}
}
