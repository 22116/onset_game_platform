<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use FOS\UserBundle\Form\Type\UsernameFormType;
use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Gesdinet\JWTRefreshTokenBundle\Model\RefreshTokenManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Manager\UserManagerInterface as AppUserManagerInterface;

/**
 * @Rest\Route("/api/auth")
 */
class AuthController extends FOSRestController
{
    /**
     * @Rest\View()
     * @Rest\Post("/register")
     * @param Request $request
     * @param TokenGeneratorInterface $tokenGenerator
     * @param UserManagerInterface $userManager
     * @param AppUserManagerInterface $appUerManager
     * @return UserInterface|FormInterface
     */
    public function register(
        Request $request,
        TokenGeneratorInterface $tokenGenerator,
        UserManagerInterface $userManager,
        AppUserManagerInterface $appUerManager)
    {
        $user = $userManager->createUser();
        $form = $this->createForm(RegistrationFormType::class, $user);

        $form->submit($request->request->getIterator()->getArrayCopy());

        if ($form->isValid()) {
            $user->setEnabled(false);
            $user->setUsername($user->getEmail());
            $user->setConfirmationToken($tokenGenerator->generateToken());
            $userManager->updateUser($user);
            $appUerManager->sendEmailConfirmation($user);
            return $user;
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
            return $this->view("failed", 400);
        }

        return $this->view("success");
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

    /**
     * @return MailerInterface|object
     */
    private function getMailer(): MailerInterface
    {
        return $this->get('fos_user.mailer.default');
    }

    /**
     * @return RefreshTokenManagerInterface|object
     */
    private function getRefreshTokenManager(): RefreshTokenManagerInterface
    {
        return $this->get('gesdinet.jwtrefreshtoken.refresh_token_manager');
    }
}
