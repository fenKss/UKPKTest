<?php

namespace App\Controller\Admin;

use App\Entity\Tour;
use App\Form\TourType;
use App\Repository\TourRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/tour", name="admin_tour_")
 */
class TourController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(TourRepository $tourRepository): Response
    {
        return $this->render('admin/tour/index.html.twig', [
            'tours' => $tourRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tour = new Tour();
        $form = $this->createForm(TourType::class, $tour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tour);
            $entityManager->flush();

            return $this->redirectToRoute('admin_tour_index');
        }

        return $this->render('admin/tour/new.html.twig', [
            'tour' => $tour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Tour $tour): Response
    {
        return $this->render('admin/tour/show.html.twig', [
            'tour' => $tour,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tour $tour): Response
    {
        $form = $this->createForm(TourType::class, $tour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_tour_index');
        }

        return $this->render('admin/tour/edit.html.twig', [
            'tour' => $tour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Tour $tour): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tour->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_tour_index');
    }
}
