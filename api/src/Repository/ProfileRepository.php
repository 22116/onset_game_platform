<?php


namespace App\Repository;


use Doctrine\ORM\EntityRepository;
use FOS\UserBundle\Model\UserInterface;

class ProfileRepository extends EntityRepository
{
    public function getProfileByUser(UserInterface $user)
    {
        return $this->findBy(['user' => $user->getId()])[0];
    }
}