<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity()
 */
class Record
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int|null
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Audio", inversedBy="record")
     */
    protected $audio;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Profile", inversedBy="records")
     * @var Profile
     */
    protected $profile;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    protected $value;

    public function __construct(Audio $audio, Profile $profile, float $value)
    {
        $this->audio = $audio;
        $this->profile = $profile;
        $this->value = $value;
    }

    /** @Groups({"API"}) */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     *  @Groups({"API"})
     */
    public function getProfile(): Profile
    {
        return $this->profile;
    }

    public function setValue(float $value): void
    {
        $this->value = $value;
    }

    public function setProfile(Profile $profile): void
    {
        $this->profile = $profile;
    }
}
