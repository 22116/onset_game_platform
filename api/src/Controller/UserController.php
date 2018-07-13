<?php

namespace App\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/api/user")
 */
class UserController extends FOSRestController
{
    /**
     * @Rest\View()
     * @Route("/current")
     * @Method({"GET"})
     */
    public function getCurrentUser()
    {
        return $this->getUser();
    }
}
