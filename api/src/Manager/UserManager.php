<?php

namespace App\Manager;

use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface as BaseUserManager;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Psr\Log\LoggerInterface;

class UserManager implements UserManagerInterface
{
    /** @var MailerInterface */
    private $mailer;

    /** @var TokenGeneratorInterface */
    private $tokenGenerator;

    /** @var BaseUserManager */
    private $userManager;

    /** @var LoggerInterface */
    private $logger;


    public function __construct(
        BaseUserManager $userManager,
        TokenGeneratorInterface $tokenGenerator,
        MailerInterface $mailer,
        LoggerInterface $logger
    ) {
        $this->userManager = $userManager;
        $this->tokenGenerator = $tokenGenerator;
        $this->mailer = $mailer;
        $this->logger = $logger;
    }

    public function sendEmailConfirmation(UserInterface $user): void
    {
        $user->setConfirmationToken($this->tokenGenerator->generateToken());
        $this->mailer->sendConfirmationEmailMessage($user);
    }

    public function sendResettingEmail(UserInterface $user): void
    {
        $user->setConfirmationToken($this->tokenGenerator->generateToken());
        $user->setPasswordRequestedAt((new \DateTime())->getTimestamp());
        $this->userManager->updateUser($user);
        $this->mailer->sendResettingEmailMessage($user);
    }
}
