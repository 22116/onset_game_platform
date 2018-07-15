<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @UniqueEntity("email")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"API"})
     * @var int
     */
    protected $id;

    /**
     * @Groups({"API"})
     * @var string
     */
    protected $username;

    /**
     * @Assert\NotBlank()
     * @Groups({"API"})
     * @Assert\Email()
     * @var string
     */
    protected $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="8")
     * @var string|null
     */
    protected $plainPassword;

    public function setEmail($email)
    {
        $this->username = $email;
        return parent::setEmail($email);
    }

    public static function create(): User
    {
        $user = new self();
        $user->setRoles(['ROLE_USER']);
        return $user;
    }
}
