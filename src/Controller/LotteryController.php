<?php

namespace App\Controller;

use App\Entity\Gift;
use App\Entity\User\User;
use App\Form\ClaimMoneyFormType;
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
     * @param User $user
     * @param Gift $gift
     * @return RedirectResponse
     * @ParamConverter("user", converter="msgphp.current_user")
     */
    public function claim(User $user, Gift $gift)
    {
        if ($gift->getType() === Gift::TYPE_LOYALTY_POINTS) {
            $this->lotteryService->addLoyaltyPoints($user, $gift);
            return new RedirectResponse('/profile');
        } elseif ($gift->getType() === Gift::TYPE_MONEY) {
            return new RedirectResponse('/claim/money/' . $gift->getId());
        } elseif ($gift->getType() === Gift::TYPE_PHYSICAL) {
            return new RedirectResponse('/claim/physical/' . $gift->getId());
        }
    }

    /**
     * @Route("/reject/{gift}", name="reject")
     * @param Request $request
     * @param User $user
     * @param Gift $gift
     * @return RedirectResponse
     * @ParamConverter("user", converter="msgphp.current_user")
     */
    public function reject(Request $request, User $user, Gift $gift)
    {
        $this->lotteryService->rejectGift($gift);
        return new RedirectResponse('/profile');
    }

    /**
     * @Route("/claim/money/{gift}", name="claimmoney")
     * @param Request $request
     * @param User $user
     * @param Gift $gift
     * @param FormFactoryInterface $formFactory
     * @return RedirectResponse
     * @ParamConverter("user", converter="msgphp.current_user")
     */
    public function claimMoney(Request $request, User $user, Gift $gift, FormFactoryInterface $formFactory)
    {
        $form = $formFactory->createNamed('', ClaimMoneyFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('sendToBankAccount')->isClicked()) {
                $this->lotteryService->sendToBank($gift);

                return new RedirectResponse('/profile');
            } else {
                $this->lotteryService->convertMoneyIntoLoyaltyBonuses($gift, $user);

                return new RedirectResponse('/profile');
            }
        }

        return $this->render('lottery/claim.money.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/claim/physical/{gift}", name="claimphysical")
     * @param User $user
     * @param Gift $gift
     * @return RedirectResponse
     * @ParamConverter("user", converter="msgphp.current_user")
     */
    public function claimPhysical(User $user, Gift $gift)
    {
        // TODO: Make form with inputting addresses in order to ship item

        return new RedirectResponse('/profile');
    }
}
