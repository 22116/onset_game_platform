<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use App\Manager\UserManagerInterface as AppUserManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use FOS\UserBundle\Form\Type\ResettingFormType;
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
     * @param AppUserManagerInterface $appUserManager
     * @return FormInterface|View
     */
    public function register(
        Request $request,
        UserManagerInterface $userManager,
        AppUserManagerInterface $appUserManager
    ) {
        $user = $userManager->createUser();
        $form = $this->createForm(RegistrationFormType::class, $user);

        $form->submit($request->request->getIterator()->getArrayCopy());

        if ($form->isValid()) {
            $user->setEnabled(false);
            $user->setUsername($user->getEmail());
            $appUserManager->sendEmailConfirmation($user);
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

    /**
     * @Rest\View()
     * @Rest\Post("/resetting")
     * @Rest\RequestParam(name="email", nullable=false, description="User email")
     * @param ParamFetcherInterface $fetcher
     * @param UserManagerInterface $userManager
     * @param AppUserManagerInterface $appUserManager
     * @return View
     */
    public function resetting(
        ParamFetcherInterface $fetcher,
        UserManagerInterface $userManager,
        AppUserManagerInterface $appUserManager
    ): View {
        $email = $fetcher->get('email');
        $user = $userManager->findUserByEmail($email);

        if (null !== $user) {
            $appUserManager->sendResettingEmail($user);
        }

        return $this->view(null, 200);
    }

    /**
     * @Rest\View()
     * @Rest\Post("/resetting/confirm")
     * @Rest\RequestParam(name="data", nullable=false, description="form-data")
     * @Rest\RequestParam(name="token", nullable=false, description="token")
     * @param ParamFetcherInterface $fetcher
     * @param UserManagerInterface $userManager
     * @return View|FormInterface
     */
    public function confirmPassword(ParamFetcherInterface $fetcher, UserManagerInterface $userManager)
    {
        $data = $fetcher->get('data');
        $token = $fetcher->get('token');

        $user = $userManager->findUserByConfirmationToken($token);
        $limit = 2 * 3600;

        if (null !== $user && $user->isPasswordRequestNonExpired($limit)) {
            $form = $this->createForm(ResettingFormType::class, $user);
            $form->submit($data);

            if ($form->isValid()) {
                $userManager->updatePassword($user);
                return $this->view(null, 200);
            }

            return $form;
        }

        return $this->view(null, 400);
    }

    private function getRefreshTokenManager(): RefreshTokenManagerInterface
    {
        return $this->get('gesdinet.jwtrefreshtoken.refresh_token_manager');
    }
}
