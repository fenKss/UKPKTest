<?php

namespace App\Controller;

use App\Repository\OlympRepository;
use App\Service\PaginationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class OlympController
 *
 * @Route("/olymp", name="olymp_")
 * @package App\Controller
 */
class OlympController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(OlympRepository $olympRepository, PaginationService $pagination): Response
    {
        $queryOlymps = $olympRepository->getWithPublishedToursQuery();
        $olymps = $pagination->paginate($queryOlymps, 3);

        return $this->render('olymp/index.html.twig', [
            'olymps' => $olymps,
            'lastPage' => $pagination->lastPage($olymps),
        ]);
    }
}
