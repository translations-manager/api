<?php

namespace AppBundle\Security;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    /**
     * @var EntityRepository
     */
    private $userRepository;

    /**
     * @param EntityRepository $userRepository
     */
    public function __construct(EntityRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByUsername($username)
    {
        return $this->userRepository->findOneBy(['username' => $username]);
    }

    /**
     * @param string $token
     *
     * @return null|User
     */
    public function loadUserByToken($token)
    {
        return $this->userRepository->findOneBy(['authToken' => $token]);
    }

    /**
     * {@inheritdoc}
     */
    public function refreshUser(UserInterface $user)
    {
        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return $class === User::class;
    }
}
