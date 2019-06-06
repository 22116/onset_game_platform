<?php

namespace App\Repository;

use App\Entity\Audio;
use Doctrine\ORM\EntityRepository;

class AudioRepository extends EntityRepository
{
    /** @param array<float> $fft */
    public function findOneByFft(array $fft): ?Audio
    {
        return $this->createQueryBuilder('t')
            ->where("t.fft = '".json_encode($fft)."'")
            ->getQuery()
            ->getResult()[0] ?? null;
    }
}
