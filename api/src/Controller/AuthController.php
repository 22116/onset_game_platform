<?php

namespace App\Controller;

use App\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
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
     * @Rest\Post("/logout")
     * @Rest\RequestParam(name="refresh_token", nullable=false, description="Refresh token to dump")
     * @param ParamFetcherInterface $fetcher
     * @param RefreshTokenManagerInterface $manager
     */
    public function logout(ParamFetcherInterface $fetcher, RefreshTokenManagerInterface $manager): void
    {
        $token = $manager->get($fetcher->get('refresh_token'));
        $manager->delete($token);
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
