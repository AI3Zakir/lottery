<?php
/**
 * Created by PhpStorm.
 * User: lamiev
 * Date: 2/20/19
 * Time: 2:41 PM
 */

namespace App\Service;

use App\Entity\Gift;
use App\Entity\GiftItemLoyalty;
use App\Entity\GiftItemMoney;
use App\Entity\GiftItemPhysical;
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
            $giftItem = new GiftItemMoney();
            $giftItem->setAmount(rand($minMoney, $maxMoney));
            $giftItem->setConverted(false);
            $giftItem->setGift($gift);
        } elseif ($randomType === Gift::TYPE_LOYALTY_POINTS) {
            $minLoyalty = $this->container->getParameter('lottery_min_loyalty');
            $maxLoyalty = $this->container->getParameter('lottery_max_loyalty');
            $giftItem = new GiftItemLoyalty();
            $giftItem->setAmount(rand($minLoyalty, $maxLoyalty));
            $giftItem->setGift($gift);
        } elseif ($randomType === Gift::TYPE_PHYSICAL) {
            $availablePhysicalGifts = $this->container->getParameter('lottery_physical_gifts');
            $giftItem = new GiftItemPhysical();
            $giftItem->setName($availablePhysicalGifts[array_rand($availablePhysicalGifts)]);
            $giftItem->setGift($gift);
        }
        $gift->setStatus(Gift::PENDING);
        $this->entityManager->persist($gift);
        $this->entityManager->flush();
    }

    public function addLoyaltyPoints(User $user, Gift $gift)
    {
        $user->setLoyaltyBalance($user->getLoyaltyBalance() + $gift->getLoyalty()->getAmount());
        $gift->setStatus(Gift::CLAIMED);
        $this->entityManager->persist($user);
        $this->entityManager->persist($gift);
        $this->entityManager->flush();
    }

    public function rejectGift(Gift $gift)
    {
        $gift->setStatus(Gift::REJECTED);
        $this->entityManager->persist($gift);
        $this->entityManager->flush();
    }
}