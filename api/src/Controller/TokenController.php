<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Form\EditTokenFormType;
use App\Repository\ProfileRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/api/token")
 */
class TokenController extends FOSRestController
{
    /**
     * @Rest\View()
     * @Rest\Patch()
     * @param Request $request
     * @return View|FormInterface
     */
    public function editToken(Request $request)
    {
        $profile = $this->getProfileRepository()->getProfileByUser($this->getUser());
        $token = $profile->getToken();

        if (null !== $token) {
            $form = $this->createForm(EditTokenFormType::class, $token);

            $form->submit($request->request->getIterator()->getArrayCopy());

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($token);
                $em->flush();

                return $this->view(null, 200);
            }

            return $form;
        }

        return $this->view("Token doesn't exists", 400);
    }

    private function getProfileRepository(): ProfileRepository
    {
        return $this->getDoctrine()->getRepository(Profile::class);
    }
}
