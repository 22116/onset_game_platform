<?php

namespace App\Entity;

use App\Validator\Constraints as AppAssert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TokenRepository")
 * @UniqueEntity("name")
 * @UniqueEntity("address")
 */
class Token
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"API"})
     * @Assert\NotBlank()
     * @Assert\Regex("/^[a-zA-Z0-9 ]+$/")
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"API"})
     * @var string
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"API"})
     * @Assert\Url()
     * @var string|null
     */
    private $websiteUrl;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"API"})
     * @AppAssert\IsFacebookUrl()
     * @var string|null
     */
    private $facebookUrl;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"API"})
     * @var string|null
     */
    private $description;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Profile", inversedBy="token", cascade={"persist"})
     * @Groups({"API"})
     * @var Profile
     */
    private $profile;

    public function __construct(Profile $profile, string $address)
    {
        $this->profile = $profile;
        $this->address = $address;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getWebsiteUrl(): ?string
    {
        return $this->websiteUrl;
    }

    public function setWebsiteUrl(string $websiteUrl): self
    {
        $this->websiteUrl = $websiteUrl;

        return $this;
    }

    public function getFacebookUrl(): ?string
    {
        return $this->facebookUrl;
    }

    public function setFacebookUrl(string $facebookUrl): self
    {
        $this->facebookUrl = $facebookUrl;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getProfile(): Profile
    {
        return $this->profile;
    }
}