<?php
namespace App\Factory;
use App\Parser\MailRuNewsParser;
use App\Parser\RBCNewsParser;
use App\Repository\NewsSiteRepository;
use InvalidArgumentException;

class NewsParserFactory implements NewsParserFactoryInterface
{
    protected NewsSiteRepository $newsSiteRepository;

    public function __construct(NewsSiteRepository $newsSiteRepository){
        $this->newsSiteRepository = $newsSiteRepository;
    }

    public function createParser(string $newsSiteName): NewsParserInterface
    {
        $newsSite = $this->newsSiteRepository->findOneBy(['name' => $newsSiteName]);

        if (!$newsSite) {
            throw new InvalidArgumentException("No such parser yet");
        }
        $newsSiteUrl = $newsSite->getUrl();

        return match ($newsSiteName) {
            'Rbc.ru' => new RBCNewsParser($newsSiteUrl),
            'Mail.ru' => new MailRuNewsParser($newsSiteUrl),
            default => throw new InvalidArgumentException("No such parser yet"),
        };
    }
}

