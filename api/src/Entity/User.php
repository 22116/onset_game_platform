<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @UniqueEntity("email")
 */
class User extends BaseUser
{
    public function __construct()
    {
        parent::__construct();

        $profile = new Profile();
        $profile->setUser($this);

        $this->setProfile($profile);
    }

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

    /**
     * @ORM\OneToOne(targetEntity="Profile", cascade={"persist"})
     * @Groups({"API"})
     * @var Profile
     */
    protected $profile;

    public function getProfile(): Profile
    {
        return $this->profile;
    }

    public function setProfile(Profile $profile): void
    {
        $this->profile = $profile;
    }

    /** {@inheritdoc} */
    public function setEmail($email)
    {
        $this->username = $email;
        return parent::setEmail($email);
    }
}
