<?php

namespace AppBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @param Request $request
     *
     * @return array|null
     */
    public function getCredentials(Request $request)
    {
        $token = $request->headers->get('X-AUTH-TOKEN');
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        if (!$token && (!$username || !$password)) {
            return null;
        }

        return [
            'token' => $token,
            'username' => $username,
            'password' => $password
        ];
    }

    /**
     * @param array $credentials
     * @param UserProviderInterface $userProvider
     *
     * @return UserInterface
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        if (isset($credentials['token'])) {
            return $userProvider->loadUserByUsername($credentials['token']);
        }

        return $userProvider->loadUserByUsername($credentials['username']);
    }

    /**
     * @param array $credentials
     * @param UserInterface $user
     *
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        if (isset($credentials['username'])) {
            $encoder = new BCryptPasswordEncoder(12);

            return $encoder->isPasswordValid($user->getPassword(), $credentials['password'], '');
        }

        return true;
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey
     *
     * @return null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     *
     * @return JsonResponse
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $data = array(
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
        );

        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }

    /**
     * @param Request $request
     * @param AuthenticationException|null $authException
     *
     * @return JsonResponse
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = array(
            'message' => 'Authentication Required'
        );

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @return bool
     */
    public function supportsRememberMe()
    {
        return false;
    }
}
