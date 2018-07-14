<?php

namespace App\Controller;

use App\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Rest\Route("/api/user")
 */
class UserController extends FOSRestController
{
    /**
     * @Rest\View()
     * @Rest\Get("/current")
     * @return User|View
     */
    public function getCurrentUser()
    {
        return $this->getUser();
    }
}
