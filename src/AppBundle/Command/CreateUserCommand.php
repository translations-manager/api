<?php

namespace AppBundle\Command;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;

class CreateUserCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('api:user:create')
            ->setDescription('Creates a new user for the API')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $userRepository = $this->getContainer()->get('app.repository.user');
        $entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
        $encoder = new BCryptPasswordEncoder(12);

        $output->writeln('<info>Hello ! Let\'s create a new user for the API !</info>');

        $validUsername = false;
        $question = new Question('What username ? ');
        while (!$validUsername) {
            $username = $helper->ask($input, $output, $question);
            if ($userRepository->findOneBy(['username' => $username])) {
                $output->writeln('<error>User already exists</error>');
            } else {
                $validUsername = true;
            }
        }
        $question = new Question('What password now ? ');
        $password = $helper->ask($input, $output, $question);

        $user = new User();
        $user->setUsername($username);
        $user->setPassword($encoder->encodePassword($password, ''));
        $user->setAuthToken(uniqid());
        $entityManager->persist($user);
        $entityManager->flush();

        $output->writeln('<info>You can now use the app with this user ! How cool is that ?</info>');
    }
}
