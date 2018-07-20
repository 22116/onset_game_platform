<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Form\EditProfileFormType;
use App\Repository\ProfileRepository;
use Doctrine\Common\Persistence\ObjectRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/api/profile")
 */
class ProfileController extends FOSRestController
{
    /**
     * @Rest\View()
     * @Rest\Patch(name="profile_edit")
     * @param Request $request
     * @return View|FormInterface
     */
    public function editProfile(Request $request)
    {
        $profile = $this->getProfileRepository()->getProfileByUser($this->getUser());
        $form = $this->createForm(EditProfileFormType::class, $profile);

        $form->submit($request->request->getIterator()->getArrayCopy());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($profile);
            $em->flush();
            return $this->view(null, 200);
        }

        return $form;
    }

    private function getProfileRepository(): ProfileRepository
    {
        return $this->getDoctrine()->getRepository(Profile::class);
    }
}
