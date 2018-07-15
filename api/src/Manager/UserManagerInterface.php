<?php

namespace App\Manager;

use FOS\UserBundle\Model\UserInterface;

interface UserManagerInterface
{
    public function sendEmailConfirmation(UserInterface $user): void;
    public function sendResettingEmail(UserInterface $user): void;
}
