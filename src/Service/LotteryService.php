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
use Doctrine\ORM\EntityManagerInterface;
use MsgPhp\User\Infra\Doctrine\Repository\UserRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
    private $entityManager;

    /**
     * @var ContainerInterface $container
     */
    private $container;

    /**
     * LotteryService constructor.
     * @param GiftRepository $giftRepository
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(GiftRepository $giftRepository, UserRepository $userRepository, EntityManagerInterface $entityManager, ContainerInterface $container)
    {
        $this->giftRepository = $giftRepository;
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->container = $container;
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
        if($randomType === Gift::TYPE_MONEY) {
            $minMoney = $this->container->getParameter('lottery_min_money');
            $maxMoney = $this->container->getParameter('lottery_max_money');
            $gift->setMoney(rand($minMoney, $maxMoney));
        } elseif ($randomType === Gift::TYPE_LOYALTY_POINTS) {
            $minLoyalty = $this->container->getParameter('lottery_min_loyalty');
            $maxLoyalty = $this->container->getParameter('lottery_max_loyalty');
            $gift->setLoyaltyPoints(rand($minLoyalty, $maxLoyalty));
        } elseif ($randomType === Gift::TYPE_PHYSICAL) {
            $availablePhysicalGifts = $this->container->getParameter('lottery_physical_gifts');
            $gift->setPhysicalItem(array_rand($availablePhysicalGifts));
        }
        $this->entityManager->persist($gift);
        $this->entityManager->flush();
    }
}