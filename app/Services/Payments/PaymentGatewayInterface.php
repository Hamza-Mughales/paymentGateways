<?php

namespace App\Services\Payments;

interface PaymentGatewayInterface
{
    public function charge(float $amount, array $options = []): array;
}
