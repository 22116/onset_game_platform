<?php

namespace App\Entity;

use App\Repository\AudioRepository;
use Doctrine\ORM\EntityManagerInterface;

class AudioManager implements AudioManagerInterface
{
    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /** {@inheritDoc} */
    public function findByFft(array $fft): ?Audio
    {
        return $this->getRepository()->findOneByFft($fft);
    }

    public function find(int $id): ?Audio
    {
        return $this->getRepository()->find($id);
    }

    public function save(Audio $audio): void
    {
        $this->em->persist($audio);
        $this->em->flush();
    }

    /** {@inheritDoc} */
    public function findAll(): array
    {
        return $this->getRepository()->findAll();
    }

    private function getRepository(): AudioRepository
    {
        return $this->em->getRepository(Audio::class);
    }
}
