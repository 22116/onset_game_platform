<?php

namespace App\Communications\Api;

interface OnsetDetectorInterface
{
    public function getData(string $filename): Onset;
}
