<?php

namespace App\Services\Payments;

use Stripe\Stripe;
use Stripe\PaymentIntent;

class StripePaymentGateway implements PaymentGatewayInterface
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function charge(float $amount, array $options = []): array
    {
        $paymentIntent = PaymentIntent::create([
            'amount' => $amount * 100, // Convert to cents
            'currency' => $options['currency'] ?? 'usd',
            'payment_method' => $options['payment_method'] ?? null,
            'confirm' => true,
        ]);

        return $paymentIntent->toArray();
    }
}
