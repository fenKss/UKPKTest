<?php

namespace App\Controller\Admin;

use App\Entity\Test;
use App\Entity\Tour;
use App\Form\TestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/tour/{tour}/test", name="admin_test_")
 */
class TestController extends AbstractController
{

    /**
     * @Route("/", name="index", methods={"GET"})
     * @param Tour $tour
     *
     * @return Response
     */
    public function tests(Tour $tour): Response
    {
        $tests = $tour->getTests();
        return $this->render('admin/test/index.html.twig', [
            'tests' => $tests,
            'tour' => $tour
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     * @param Tour    $tour
     * @param Request $request
     *
     * @return Response
     */
    public function new(Tour $tour, Request $request): Response
    {
        if ($tour->getPublishedAt()) {
            $this->addFlash('error','Тур опубликован. Нужно сначала сделать его неопубликованным');
            return $this->redirectToRoute('admin_test_index', [
                "tour" => $tour->getId()
            ]);
        }
        $test = new Test();
        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $test->setTour($tour);
            $isValid = $this->validate($test);

            if ($isValid) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($test);
                $entityManager->flush();

                return $this->redirectToRoute('admin_test_index', [
                    "tour" => $tour->getId()
                ]);
            }
        }

        return $this->render('admin/test/new.html.twig', [
            "tour" => $tour,
            'test' => $test,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param Tour    $tour
     * @param Request $request
     * @param Test    $test
     *
     * @return Response
     */
    public function edit(Tour $tour, Request $request, Test $test): Response
    {
        if ($tour->getPublishedAt()) {
            $this->addFlash('error','Тур опубликован. Нужно сначала сделать его неопубликованным');
            return $this->redirectToRoute('admin_test_index', [
                "tour" => $test->getTour()->getId()
            ]);
        }
        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $isValid = $this->validate($test);

            if ($isValid === true) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('admin_test_index', [
                    "tour" => $test->getTour()->getId()
                ]);
            }
        }

        return $this->render('admin/test/edit.html.twig', [
            'test' => $test,
            'form' => $form->createView(),
            'tour' => $tour
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Tour    $tour
     * @param Request $request
     * @param Test    $test
     *
     * @return Response
     */
    public function delete(Tour $tour, Request $request, Test $test): Response
    {
        if ($tour->getPublishedAt()) {
            $this->addFlash('error','Тур опубликован. Нужно сначала сделать его неопубликованным');
            return $this->redirectToRoute('admin_test_index', [
                "tour" => $tour->getId()
            ]);
        }
        if ($this->isCsrfTokenValid('delete' . $test->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($test);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_test_index', [
            "tour" => $tour->getId()
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
    private function validateExistsLanguageInOlympic(Test $test): bool
    {
        $olympic = $test->getTour()->getOlympic();
        $language = $test->getLanguage();
        return $olympic->getLanguages()->contains($language);

    }

    private function validate(Test $test): bool
    {
        if (!$this->validateExistsLanguageInTest($test)) {
            $this->addFlash('error', 'Данный язык уже добавлен');
            return false;
        }
        if (!$this->validateExistsLanguageInOlympic($test)) {
            $this->addFlash('error', 'Данный язык не разрешен у олимпиады');
            return false;
        }
        return true;
    }
}
