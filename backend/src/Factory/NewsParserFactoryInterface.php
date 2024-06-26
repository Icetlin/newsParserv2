<?php

namespace App\Factory;

interface NewsParserFactoryInterface
{
    public function createParser(string $newsSiteName): NewsParserInterface;
}
