<?php
namespace App\Service;
use App\Factory\NewsParserFactory;
use Exception;
use Symfony\Flex\Response;

class NewsParsingService
{
    protected NewsParserFactory $newsParserFactory;

    function __construct(NewsParserFactory $newsParserFactory){
        $this->newsParserFactory = $newsParserFactory;
    }

    /**
     * @throws Exception
     */
    public function parseNews(array $parseParameters): array
    {
        [$newsSiteName, $newsCount] = $this->processParseParams($parseParameters);
        $newsParser = $this->newsParserFactory->createParser($newsSiteName);
        return $newsParser->parse($newsCount);
    }

    /**
     * @throws Exception
     */
    private function processParseParams(array $parseParameters): array
    {
        $newsSiteName = $parseParameters['site'] ?? null;
        if (!$newsSiteName) throw new Exception("Site name is required");
        $newsCount = $parseParameters['news_count'] ?? null;
        if (!$newsCount) throw new Exception("News count is required");
        return [$newsSiteName, $newsCount];
    }
}