<?php

namespace App\Command;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AddAdminCommand extends Command
{
    protected static        $defaultName        = 'app:add-admin';
    protected static string $defaultDescription = 'Make user admin by email';
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    public function __construct(
        UserRepository $userRepository,
        EntityManagerInterface $em,
        string $name = null
    ) {
        parent::__construct($name);
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addOption('email', '-em', InputOption::VALUE_REQUIRED,
                'User Email');
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getOption('email');

        if ($email) {
            $user = $this->userRepository->findOneBy([
                'email' => $email
            ]);
            if (!$user) {
                $io->error("Can't find user by $email");
                return self::FAILURE;
            }
            $user->setRoles(array_unique(array_merge($user->getRoles(),
                ['ROLE_ADMIN'])));
            $this->em->persist($user);
            $this->em->flush();
            $io->success("User $email is admin now");
            return Command::SUCCESS;
        }

        return Command::FAILURE;


    }
}
