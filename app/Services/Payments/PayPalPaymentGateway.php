<?php 

// app/Services/Payments/PayPalPaymentGateway.php
namespace App\Services\Payments;

use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

class PayPalPaymentGateway implements PaymentGatewayInterface
{
    public function charge(float $amount, array $options = []): array
    {
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $amountInstance = new Amount();
        $amountInstance->setCurrency($options['currency'] ?? 'USD')
            ->setTotal($amount);

        $transaction = new Transaction();
        $transaction->setAmount($amountInstance)
            ->setDescription("Payment description");

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($options['return_url'])
            ->setCancelUrl($options['cancel_url']);

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);

        $payment->create();

        return [
            'payment_id' => $payment->getId(),
            'approval_url' => $payment->getApprovalLink(),
        ];
    }
}
