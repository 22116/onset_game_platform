<?php

namespace App\Communications\Api;

class Onset
{
    /** @var array<float> */
    private $fft;

    /** @var array<float> */
    private $beats;

    /**
     * Onset constructor.
     * @param array<float> $fft
     * @param array<float> $beats
     */
    public function __construct(array $fft, array $beats)
    {
        $this->fft = $fft;
        $this->beats = $beats;
    }

    /**
     * @return array<float>
     */
    public function getFft(): array
    {
        return $this->fft;
    }

    /**
     * @return array<float>
     */
    public function getBeats(): array
    {
        return $this->beats;
    }

    public function getDuration(): int
    {
        return intval(count($this->getFft()) / 2);
    }
}
