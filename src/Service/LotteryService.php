<?php
/**
 * Created by PhpStorm.
 * User: lamiev
 * Date: 2/20/19
 * Time: 2:41 PM
 */

namespace App\Service;

use App\Entity\Gift;
use App\Entity\User\User;
use App\Repository\GiftRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use MsgPhp\User\Infra\Doctrine\Repository\UserRepository;

class LotteryService
{
    /**
     * @var $giftRepository GiftRepository
     */
    private $giftRepository;

    /**
     * @var $userRepository UserRepository
     */
    private $userRepository;

    /**
     * @var EntityManagerInterface $entityManager
     */
    private  $entityManager;

    /**
     * LotteryService constructor.
     * @param GiftRepository $giftRepository
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(GiftRepository $giftRepository, UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->giftRepository = $giftRepository;
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param User $user
     */
    public function play($user)
    {
        $randomType = array_rand([Gift::TYPE_MONEY, Gift::TYPE_LOYALTY_POINTS, Gift::TYPE_PHYSICAL]);
        $gift = new Gift();
        $gift->setType($randomType);
        $gift->setUser($user);
        $this->entityManager->persist($gift);
        $this->entityManager->flush();
    }
}