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
     * 'data' is a required wrapper for websanova auth library
     *
     * @Rest\View()
     * @Rest\Get()
     * @return array|View
     */
    public function getCurrentUser()
    {
        return [ 'data' => $this->getUser() ];
    }
}
