<?php 

namespace App\Services\Payments;

class PaymentService
{
    protected PaymentGatewayInterface $gateway;

    public function setGateway(PaymentGatewayInterface $gateway): void
    {
        $this->gateway = $gateway;
    }

    public function charge(float $amount, array $options = []): array
    {
        if (!$this->gateway) {
            throw new \Exception("Payment gateway is not set.");
        }

        return $this->gateway->charge($amount, $options);
    }
}
