<?php

namespace App\Controller\Admin;

use App\Entity\Test;
use App\Form\TestType;
use App\Repository\TestRepository;
use App\Repository\TourRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/test", name="admin_test_")
 */
class TestController extends AbstractController
{


    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $test = new Test();
        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $isValid = $this->validateLanguagesCount($test);
            if ($isValid) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($test);
                $entityManager->flush();

                return $this->redirectToRoute('admin_tour_tests', [
                    "tourId" => $test->getTour()->getId()
                ]);
            }
            $this->addFlash('error', 'Тест с данным языком уже существует');

        }

        return $this->render('admin/test/new.html.twig', [
            'test' => $test,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Test $test): Response
    {
        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $isValid = $this->validateLanguagesCount($test);
            if ($isValid) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('admin_tour_tests', [
                    "tourId" => $test->getTour()->getId()
                ]);
            }
            $this->addFlash('error', 'Тест с данным языком уже существует');
        }

        return $this->render('admin/test/edit.html.twig', [
            'test' => $test,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Test $test): Response
    {
        if ($this->isCsrfTokenValid('delete' . $test->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($test);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_tour_tests', [
            "tourId" => $test->getTour()->getId()
        ]);
    }

    /**
     * @param Test $test
     *
     * @return bool
     */
    private function validateLanguagesCount(Test $test): bool
    {
        $tour = $test->getTour();
        $isValid = true;

        $tests = $tour->getTests();
        foreach ($tests as $tourTest) {
            if ($tourTest->getLanguage()->getId() == $test->getLanguage()->getId()
                && $test->getId() != $tourTest->getId()) {
                return false;
            }
        }
        return $isValid;

    }
}
