<?php

namespace App\Controller;

use App\Entity\User\User;
use App\Form\LotteryType;
use App\Service\LotteryService;
use MsgPhp\User\Infra\Doctrine\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class LotteryController extends AbstractController
{
    /**
     * @var LotteryService $lotterService
     */
    private $lotterService;

    /**
     * LotteryController constructor.
     * @param LotteryService $lotteryService
     */
    public function __construct(LotteryService $lotteryService)
    {
        $this->lotterService = $lotteryService;
    }


    /**
     * @Route("/lottery", name="lottery")
     * @param Request $request
     * @param FormFactoryInterface $formFactory
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     * @ParamConverter("user", converter="msgphp.current_user")
     */
    public function index(Request $request, FormFactoryInterface $formFactory,User $user)
    {
        $form = $formFactory->createNamed('', LotteryType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->lotterService->play($user);

        }
        return $this->render('lottery/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/claim", name="claim")
     * @param Request $request
     */
    public function claim(Request $request)
    {

    }
}
