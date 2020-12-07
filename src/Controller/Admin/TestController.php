<?php

namespace App\Controller\Admin;

use App\Entity\Olymp;
use App\Entity\Test;
use App\Form\TestType;
use App\Repository\OlympRepository;
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
            $isValid = $this->validate($test);

            if ($isValid){
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($test);
                $entityManager->flush();

                return $this->redirectToRoute('admin_tour_tests', [
                    "tourId" => $test->getTour()->getId()
                ]);
            }
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
            $isValid = $this->validate($test);

            if ($isValid === true) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('admin_tour_tests', [
                    "tourId" => $test->getTour()->getId()
                ]);
            }
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
    private function validateExistsLanguageInTest(Test $test): bool
    {
        $tour = $test->getTour();

        $tests = $tour->getTests();
        foreach ($tests as $tourTest) {
            if ($tourTest->getLanguage()->getId() == $test->getLanguage()->getId()
                && $test->getId() != $tourTest->getId()) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param Test $test
     *
     * @return bool
     */
    private function validateExistsLanguageInOlymp(Test $test): bool
    {
        $olymp = $test->getTour()->getOlymp();
        $language = $test->getLanguage();
        return $olymp->getLanguages()->contains($language);

    }

    private function validate(Test $test): bool
    {
        if (!$this->validateExistsLanguageInTest($test))
        {
            $this->addFlash('error', 'Данный язык уже добавлен');
            return false;
        }
        if (!$this->validateExistsLanguageInOlymp($test))
        {
            $this->addFlash('error', 'Данный язык не разрешен у олимпиады');
            return false;
        }
       return true;
    }
}
