<?php

namespace App\Command;

use App\Entity\Gift;
use App\Repository\GiftRepository;
use App\Service\PaymentService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LotterySendToBankMoneyCommand extends Command
{
    const BATCH_LIMIT = 10;
    protected static $defaultName = 'lottery:send-to-bank-money';

    /**
     * @var ContainerInterface $container
     */
    private $container;

    /**
     * @var PaymentService $paymentService
     */
    private $paymentService;

    /**
     * @var GiftRepository $giftRepository
     */
    private $giftRepository;

    /**
     * LotterySendToBankMoneyCommand constructor.
     * @param ContainerInterface $container
     * @param PaymentService $paymentService
     * @param GiftRepository $giftRepository
     */
    public function __construct(ContainerInterface $container, PaymentService $paymentService, GiftRepository $giftRepository)
    {
        parent::__construct();
        $this->container = $container;
        $this->paymentService = $paymentService;
        $this->giftRepository = $giftRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Send pending money to bank accounts')
            ->addArgument('batch', InputArgument::OPTIONAL, 'Argument description');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $batchLimit = $input->getArgument('batch') ?? self::BATCH_LIMIT;

        $offset = 0;
        while ($gifts = $this->giftRepository->findBy(['status' => Gift::PENDING_TO_SEND], null, $batchLimit, $offset * $batchLimit)) {
            /** @var Gift $gift */
            foreach ($gifts as $gift) {
                $this->paymentService->send($gift);
            }
            $offset++;
        }
        $io = new SymfonyStyle($input, $output);
        $io->success('all items are transferred to banks');
    }
}
