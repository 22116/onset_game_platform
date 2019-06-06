<?php declare(strict_types = 1);

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AudioRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Audio
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int|null
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $title = '';

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $duration;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @var DateTimeImmutable
     */
    protected $createdDate;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please, upload the audio file.")
     * @Assert\File()
     *
     * @var string
     */
    protected $file;

    /**
     * @ORM\Column(type="json_array")
     *
     * @var array<float>
     */
    protected $fft;

    /**
     * @ORM\Column(type="json_array")
     *
     * @var array<float>
     */
    protected $beats;

    /**
     * @ORM\OneToOne(targetEntity="Record", mappedBy="audio")
     * @var Record|null
     */
    protected $record;

    /** @Groups({"API"}) */
    public function getId(): ?int
    {
        return $this->id;
    }

    /** @Groups({"API"}) */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @Groups({"API"})
     * @return string|UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /** @Groups({"API"}) */
    public function getRecord(): ?Record
    {
        return $this->record;
    }

    public function setFile($path): self
    {
        $this->file = $path;

        return $this;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    /** @ORM\PrePersist() */
    public function updateCreatedDate(): self
    {
        $this->createdDate = new DateTimeImmutable();

        return $this;
    }

    /** @Groups({"API"}) */
    public function getCreatedDate(): DateTimeImmutable
    {
        return $this->createdDate ?? new DateTimeImmutable();
    }

    /** @param array<float> $fft */
    public function setFft(array $fft): self
    {
        $this->fft = $fft;

        return $this;
    }

    /** @param array<float> $fft */
    public function setBeats(array $beats): self
    {
        $this->beats = $beats;

        return $this;
    }

    /**
     * @return array<float>
     * @Groups({"API"})
     */
    public function getFft(): array
    {
        return $this->fft;
    }

    /**
     * @return array<float>
     * @Groups({"API"})
     */
    public function getBeats(): array
    {
        return $this->beats;
    }

    /** @Groups({"API"}) */
    public function getTitle(): string
    {
        return $this->title ?? '';
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
