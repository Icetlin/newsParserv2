<?php
namespace App\Service;
use App\Entity\ParsedNews;
use App\Repository\ParsedNewsRepository;
use Doctrine\ORM\EntityManagerInterface;

class NewsSavingService
{
    protected ParsedNews $parsedNews;
    protected ParsedNewsRepository $parsedNewsRepository;
    protected EntityManagerInterface $entityManager;

    public function __construct(
        ParsedNewsRepository $parsedNewsRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->parsedNewsRepository = $parsedNewsRepository;
        $this->entityManager = $entityManager;
    }
    public function saveToDatabase(array $parsedNews): void
    {
        foreach ($parsedNews as $oneParsedNews) {
            $news = new ParsedNews();
            $news
                ->setNewsUrl($oneParsedNews['link'])
                ->setTitle($oneParsedNews['title'])
                ->setContent($oneParsedNews['text'])
                ->setDate(new \DateTimeImmutable())
                ->setSource($oneParsedNews['source'])
            ;


            try {
                $this->entityManager->persist($news);
                $this->entityManager->flush();
            } catch (\Exception $e) {
                xdebug_break();
            }

        }
    }
}