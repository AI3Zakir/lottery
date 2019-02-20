<?php
/**
 * Created by PhpStorm.
 * User: lamiev
 * Date: 2/20/19
 * Time: 6:09 PM
 */

namespace App\Service;


use App\Entity\Gift;
use App\Entity\User\User;
use App\Payments\DummyPayment;
use Doctrine\ORM\EntityManagerInterface;

class PaymentService
{
    /**
     * @var DummyPayment $dummyPayment
     */
    private $dummyPayment;

    /**
     * @var EntityManagerInterface $entityManager
     */
    private $entityManager;

    /**
     * PaymentService constructor.
     * @param DummyPayment $dummyPayment
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(DummyPayment $dummyPayment,EntityManagerInterface $entityManager)
    {
        $this->dummyPayment = $dummyPayment;
        $this->entityManager = $entityManager;
    }

    public function send(Gift $gift)
    {
        /*
        TODO: Needed to implement proper solution, for bank operations can be used for example Stripe https://stripe.com/
            With PaymentInterfaces etc in order to be able add another payment options in future, also should be implemented in
            with transaction method in order revert not successfull operations
        */
        $this->dummyPayment->send($gift->getUser()->getBankAccount(), $gift->getMoney()->getAmount());
        $gift->getMoney()->setTransferred(true);
        $gift->setStatus(Gift::CLAIMED);
        $this->entityManager->persist($gift);
        $this->entityManager->flush();
    }
}