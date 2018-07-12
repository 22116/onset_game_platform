<?php

namespace App\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends FOSRestController
{
    public function getUsers(): Response
    {
        $view = $this->view();

        return $this->handleView($view);
    }
}
