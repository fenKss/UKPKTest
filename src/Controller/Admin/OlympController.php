<?php

namespace App\Controller\Admin;

use App\Entity\Olymp;
use App\Form\OlympType;
use App\Repository\OlympRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/olymp", name="admin_olymp_")
 */
class OlympController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(OlympRepository $olympRepository): Response
    {
        return $this->render('admin/olymp/index.html.twig', [
            'olymps' => $olympRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $olymp = new Olymp();
        $form = $this->createForm(OlympType::class, $olymp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($olymp);
            $entityManager->flush();

            return $this->redirectToRoute('admin_olymp_index');
        }

        return $this->render('admin/olymp/new.html.twig', [
            'olymp' => $olymp,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Olymp $olymp): Response
    {
        return $this->render('admin/olymp/show.html.twig', [
            'olymp' => $olymp,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Olymp $olymp): Response
    {
        $form = $this->createForm(OlympType::class, $olymp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_olymp_index');
        }

        return $this->render('admin/olymp/edit.html.twig', [
            'olymp' => $olymp,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Olymp $olymp): Response
    {
        if ($this->isCsrfTokenValid('delete'.$olymp->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($olymp);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_olymp_index');
    }
}
