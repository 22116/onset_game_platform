<?php

namespace App\Utils;

interface TagReaderInterface
{
    public function read(string $path): array;
}
