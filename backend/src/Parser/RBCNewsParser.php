<?php

namespace App\Parser;
use App\Factory\NewsParserInterface;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;


class RBCNewsParser implements NewsParserInterface
{
    protected string $newsSiteUrl;

    public function __construct(string $newsSiteUrl)
    {
        $this->newsSiteUrl = $newsSiteUrl;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws \Exception
     */
    public function parse($newsCount): array
    {
        $httpClient = HttpClient::create();

        $response = $httpClient->request('GET', $this->newsSiteUrl);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Failed to fetch news page');
        }

        $content = $response->getContent();

        if (empty($content)) {
            throw new \Exception('Failed to fetch news page content');
        }

        $crawler = new Crawler($content);

        $crawler->filter('.main__feed.js-main-reload-item') // измените селектор на соответствующий вашему сайту
        ->slice(0, $newsCount)
            ->each(function (Crawler $node, $i) use (&$newsItems) {
                $title = $node->filter('.main__feed__title')->text(); // измените селектор на соответствующий вашему сайту
                $link = $node->filter('a')->attr('href'); // измените селектор на соответствующий вашему сайту

                $httpClient = HttpClient::create();

                $response = $httpClient->request('GET', $link);

                if ($response->getStatusCode() !== 200) {
                    throw new \Exception('Failed to fetch news page');
                }

                $content = $response->getContent();

//                xdebug_break();
                if (empty($content)) {
                    throw new \Exception('Failed to fetch news page content');
                }

                $newsCrawler = new Crawler($content);

                try {
                    $text = $newsCrawler->filter('.article__text')->text();
                } catch (\Exception $exception){
                    return;
                }

                $text = strlen($text) > 10000 ? substr($text, 0, 10000) : $text;

                $text = preg_replace('/[^\p{L}\s\p{P}]/u', '', $text);
//                $text = preg_replace('/\p{C}/u', '', $text);
                $text = preg_replace('/[^\p{L}\s\p{P}]|�/u', '', $text);




                $newsItems[] = [
                    'title'  => $title,
                    'link'   => $link,
                    'text'   => $text,
                    'source' => $this->newsSiteUrl
                ];
            });

        return $newsItems;
    }
}