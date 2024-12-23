<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Payments\PaymentService;
use App\Services\Payments\StripePaymentGateway;
use App\Services\Payments\PayPalPaymentGateway;

class PaymentController extends Controller
{
    protected PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function processPayment(Request $request)
    {
        $gateway = $request->input('gateway'); // 'stripe' or 'paypal'

        switch ($gateway) {
            case 'stripe':
                $this->paymentService->setGateway(new StripePaymentGateway());
                break;

            case 'paypal':
                $this->paymentService->setGateway(new PayPalPaymentGateway());
                break;

            default:
                return response()->json(['error' => 'Invalid payment gateway'], 400);
        }

        try {
            $result = $this->paymentService->charge($request->input('amount'), $request->all());
            return response()->json(['success' => true, 'data' => $result]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
