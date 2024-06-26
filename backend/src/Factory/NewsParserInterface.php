<?php

namespace App\Factory;

interface NewsParserInterface
{
    public function parse($newsCount): array;
}