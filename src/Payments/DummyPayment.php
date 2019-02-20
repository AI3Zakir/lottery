<?php
/**
 * Created by PhpStorm.
 * User: lamiev
 * Date: 2/20/19
 * Time: 6:16 PM
 */

namespace App\Payments;


class DummyPayment implements PaymentInterface
{

    public function send($bankAccount, $amount)
    {
        // Placeholder for future implementation of sending money
        //        try {
        //            Stripe::send($bankAccount, $amount);
        //        } catch (\Exception $exception) {
        //
        //        }
    }
}