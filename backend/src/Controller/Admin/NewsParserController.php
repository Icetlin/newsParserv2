<?php

namespace App\Controller\Admin;

use App\Entity\NewsSite;
use App\Repository\NewsSiteRepository;
use App\Service\NewsParsingService;
use App\Service\NewsSavingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsParserController extends AbstractController
{
    protected NewsSiteRepository $newsRepository;
    protected NewsParsingService $newsParsingService;
    protected NewsSavingService $newsSavingService;

    function __construct(
        NewsSiteRepository $newsSiteRepository,
        NewsParsingService $newsParsingService,
        NewsSavingService $newsSavingService
    )
    {
        $this->newsRepository = $newsSiteRepository;
        $this->newsParsingService = $newsParsingService;
        $this->newsSavingService = $newsSavingService;
    }

    /**
     * @throws \Exception
     */
    #[Route('/backend/admin/news_parser', name: 'admin_news_parser')]
    public function index(Request $request): Response
    {
        $newsSites = $this->newsRepository->findAll();

        if ($request->isMethod('POST')) {
            $parseParameters = $request->request->all();
            $parsedNews = $this->newsParsingService->parseNews($parseParameters);

            if ($parsedNews) {
                $this->newsSavingService->saveToDatabase($parsedNews);
                $this->addFlash('success', 'Спарсенные новости успешно сохранены в базе данных');
            } else {
                $this->addFlash('error', 'Произошла ошибка при парсинге новостей');
            }
        }

        return $this->render('admin/news_parser.html.twig', [
            'newsSites' => $newsSites,
            'parsingInProgress' => true,
        ]);
    }

}
