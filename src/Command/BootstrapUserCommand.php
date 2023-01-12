<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:bootstrap:user',
    description: 'Add a short description for your command',
)]
class BootstrapUserCommand extends Command
{
    private UserRepository $userRepository;

    public function __construct( UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::OPTIONAL, 'admin email', 'admin@localhost')
            ->addArgument('password', InputArgument::OPTIONAL, 'admin password', 'qweqwe')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');

        if ($email) {
            $io->note(sprintf('Going to create admin user with email: %s', $email));

            if($this->userRepository->findOneBy(['email' => $email])) {
                $io->error(sprintf('User with email: %s already exists', $email));
                return Command::FAILURE;
            }

            $user  = new User();
            $user->setEmail($email);
            $user->setPlainPassword($input->getArgument('password'));

            $this->userRepository->save($user);

        }

        $io->success('You have a new user! ');

        return Command::SUCCESS;
    }
}
