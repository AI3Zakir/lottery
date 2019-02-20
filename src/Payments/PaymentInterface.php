<?php
/**
 * Created by PhpStorm.
 * User: lamiev
 * Date: 2/20/19
 * Time: 6:15 PM
 */

namespace App\Payments;


interface PaymentInterface
{
    public function send($bankAccount, $amount);
}