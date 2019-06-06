<?php

namespace App\Entity;

interface AudioManagerInterface
{
    /** @param array<float> $fft */
    public function findByFft(array $fft): ?Audio;
    public function find(int $id): ?Audio;
    public function save(Audio $audio): void;
    /** @return array<Audio> */
    public function findAll(): array;
}
