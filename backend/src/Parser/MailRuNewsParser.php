<?php
namespace App\Parser;
use App\Factory\NewsParserInterface;

class MailRuNewsParser implements NewsParserInterface
{
    protected string $newsSiteUrl;

    public function __construct(string $newsSiteUrl)
    {
        $this->newsSiteUrl = $newsSiteUrl;
    }

    public function parse($newsCount): array
    {
        return [];
    }
}