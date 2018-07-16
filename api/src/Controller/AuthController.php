<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use App\Manager\UserManagerInterface as AppUserManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use FOS\UserBundle\Form\Type\UsernameFormType;
use FOS\UserBundle\Model\UserManagerInterface;
use Gesdinet\JWTRefreshTokenBundle\Model\RefreshTokenManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/api/auth")
 */
class AuthController extends FOSRestController
{
    /**
     * @Rest\View()
     * @Rest\Post("/register")
     * @param Request $request
     * @param UserManagerInterface $userManager
     * @param AppUserManagerInterface $appUerManager
     * @return FormInterface|View
     */
    public function register(
        Request $request,
        UserManagerInterface $userManager,
        AppUserManagerInterface $appUerManager
    ) {
        $user = $userManager->createUser();
        $form = $this->createForm(RegistrationFormType::class, $user);

        $form->submit($request->request->getIterator()->getArrayCopy());

        if ($form->isValid()) {
            $user->setEnabled(false);
            $user->setUsername($user->getEmail());
            $appUerManager->sendEmailConfirmation($user);
            $userManager->updateUser($user);
            return $this->view(null, 200);
        }

        return $form;
    }

    /**
     * @Rest\View()
     * @Rest\Post("/logout")
     * @Rest\RequestParam(name="refresh_token", nullable=false, description="Refresh token to dump")
     * @param ParamFetcherInterface $fetcher
     * @return View
     */
    public function logout(ParamFetcherInterface $fetcher): View
    {
        $manager = $this->getRefreshTokenManager();
        $token = $manager->get($fetcher->get('refresh_token'));

        if (null !== $token) {
            $manager->delete($token);
        } else {
            return $this->view(null,400);
        }

        return $this->view(null, 200);
    }

    /**
     * @Rest\View()
     * @Rest\Post("/register/confirm")
     * @Rest\RequestParam(name="token", nullable=false, description="Registration confirmation token")
     * @param ParamFetcherInterface $fetcher
     * @param UserManagerInterface $userManager
     * @return View
     */
    public function confirmEmail(ParamFetcherInterface $fetcher, UserManagerInterface $userManager): View
    {
        $token = $fetcher->get('token');
        $user = $userManager->findUserByConfirmationToken($token);

        if (null !== $user) {
            $user->setEnabled(true);
            $user->setConfirmationToken(null);
            $userManager->updateUser($user);
            return $this->view(null, 200);
        }

        return $this->view(null, 400);
    }

    public function forgotPassword(): void
    {
        $form = $this->createForm(UsernameFormType::class);
        //TODO: find user and send email
    }

    public function resetting(): void
    {
        //TODO: save new password with token received from email
    }

    private function getRefreshTokenManager(): RefreshTokenManagerInterface
    {
        return $this->get('gesdinet.jwtrefreshtoken.refresh_token_manager');
    }
}
