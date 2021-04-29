<?php

namespace App\Controller\Admin;

use App\Entity\Olympic;
use App\ENum\EOlympicType;
use App\Form\OlympicType;
use App\Repository\OlympicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/olympic", name="admin_olympic_")
 */
class OlympicController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(OlympicRepository $olympicRepository): Response
    {
        $typesRaw = EOlympicType::toArray();
        $types = [];
        foreach ($typesRaw as $type) {
            switch ($type) {
                case EOlympicType::COLLEGE_TYPE:
                    $typeLoc = "Внутриколледжная";
                    break;
                case EOlympicType::CITY_TYPE:
                    $typeLoc = "Городская";
                    break;
                case EOlympicType::COUNTRY_TYPE:
                    $typeLoc = "Республиканская";
                    break;
                case EOlympicType::REGION_TYPE:
                    $typeLoc = "Региональная";
                    break;
                case EOlympicType::WORLD_TYPE:
                    $typeLoc = "Международная";
                    break;
                default:
                    $typeLoc = null;
            }
            $types[$type] = $typeLoc;
        }
        return $this->render('admin/olympic/index.html.twig', [
            'olympics' => $olympicRepository->getWithAll(),
            'types'    => $types
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $olympic = new Olympic();
        $form = $this->createForm(OlympicType::class, $olympic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($olympic);
            $entityManager->flush();

            return $this->redirectToRoute('admin_olympic_index');
        }

        return $this->render('admin/olympic/new.html.twig', [
            'olympic' => $olympic,
            'form'    => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Olympic $olympic): Response
    {
        return $this->render('admin/olympic/show.html.twig', [
            'olympic' => $olympic,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Olympic $olympic): Response
    {
        $form = $this->createForm(OlympicType::class, $olympic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_olympic_index');
        }

        return $this->render('admin/olympic/edit.html.twig', [
            'olympic' => $olympic,
            'form'    => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Olympic $olympic): Response
    {
        if ($this->isCsrfTokenValid('delete' . $olympic->getId(),
            $request->request->get('_token'))
        ) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($olympic);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_olympic_index');
    }
}
