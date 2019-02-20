<?php

namespace App\Controller;

use App\Entity\Gift;
use App\Entity\User\User;
use App\Form\LotteryType;
use App\Repository\GiftRepository;
use App\Service\LotteryService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LotteryController extends AbstractController
{
    /**
     * @var LotteryService $lotteryService
     */
    private $lotteryService;

    /**
     * LotteryController constructor.
     * @param LotteryService $lotteryService
     */
    public function __construct(LotteryService $lotteryService)
    {
        $this->lotteryService = $lotteryService;
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
            $this->lotteryService->play($user);

            return new RedirectResponse('/list');
        }
        return $this->render('lottery/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/list", name="list")
     * @param User $user
     * @param GiftRepository $giftRepository
     * @return \Symfony\Component\HttpFoundation\Response
     * @ParamConverter("user", converter="msgphp.current_user")
     */
    public function list(User $user, GiftRepository $giftRepository)
    {
        $availableGifts = $giftRepository->findBy([
            'user' => $user,
            'status' => Gift::PENDING
        ]);

        return $this->render('lottery/list.html.twig', [
            'gifts' => $availableGifts,
        ]);
    }

    /**
     * @Route("/claim/{gift}", name="claim")
     * @param Request $request
     * @param User $user
     * @param Gift $gift
     * @return void
     * @ParamConverter("user", converter="msgphp.current_user")
     */
    public function claim(Request $request, User $user, Gift $gift)
    {

    }

    /**
     * @Route("/reject/{gift}", name="reject")
     * @param Request $request
     * @param User $user
     * @param Gift $gift
     * @return void
     * @ParamConverter("user", converter="msgphp.current_user")
     */
    public function reject(Request $request, User $user, Gift $gift)
    {

    }
}
