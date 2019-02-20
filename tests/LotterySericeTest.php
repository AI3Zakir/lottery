<?php

namespace App\Tests;

use App\Entity\Gift;
use App\Entity\GiftItemMoney;
use App\Entity\User\User;
use App\Service\LotteryService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LotteryServiceTest extends WebTestCase
{
    public function testHomepage()
    {
        // Just to show ability to make BDD tests
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testConvert()
    {
        self::bootKernel();

        $container = self::$container;

        /** @var LotteryService $lotteryService */
        $lotteryService = $container->get('App\Service\LotteryService');
        $gift = new Gift();
        $ratio = 10;
        $gift->setType(Gift::TYPE_MONEY);
        $gift->setStatus(Gift::PENDING);
        $giftMoneyItem = new GiftItemMoney();
        $giftMoneyItem->setAmount(100);
        $giftMoneyItem->setConverted(false);
        $giftMoneyItem->setTransferred(false);
        $giftMoneyItem->setGift($gift);
        $this->assertEquals(1000, $lotteryService->convert($ratio, $gift));
    }
}
