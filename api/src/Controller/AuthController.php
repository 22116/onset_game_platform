<?php

namespace App\Controller;

use App\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use FOS\UserBundle\Form\Type\RegistrationFormType;
use FOS\UserBundle\Form\Type\UsernameFormType;
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
     * @return User|FormInterface
     */
    public function register(Request $request)
    {
        $user = User::create();
        $form = $this->createForm(RegistrationFormType::class, $user);

        $form->submit($request->request->getIterator()->getArrayCopy());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
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
        /** @var RefreshTokenManagerInterface $manager */
        $manager = $this->get('gesdinet.jwtrefreshtoken.refresh_token_manager');
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
}
