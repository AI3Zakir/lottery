<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LotteryController extends AbstractController
{
    /**
     * @Route("/lottery", name="lottery")
     */
    public function index()
    {
        return $this->render('lottery/index.html.twig', [
            'controller_name' => 'LotteryController',
        ]);
    }
}
