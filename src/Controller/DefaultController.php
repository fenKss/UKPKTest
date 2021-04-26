<?php

namespace App\Controller;

use App\Repository\OlympicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(OlympicRepository $olympicRepository): Response
    {
        $limit = 2;

        $olympics = $olympicRepository->getWithPublishedTours($limit);
        return $this->render('title.html.twig', [
            'count'    => count($olympics),
            'olympics' => $olympics
        ]);
    }

    /**
     * @Route("/admin", name="admin_index")
     */
    public function admin(): Response
    {
        return $this->render('admin/base.html.twig');
    }
}
