<?php

namespace App\Controller\Admin;

use App\Entity\Variant;
use App\Entity\Test;
use App\Entity\Tour;
use App\Repository\VariantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/tour/{tour}/test/{test}", name="admin_variant_")
 */
class VariantController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(Tour $tour, Test $test, VariantRepository $variantRepository): Response
    {
        $variants = $variantRepository->getByTestWithQuestions($test);
        $letters = [];
        foreach ($variants as $key => $variant) {
            $letters[$variant->getId()] = chr(substr("000".($key+65),-3));
        }
        return $this->render('admin/variant/index.html.twig', [
            'variants' => $variants,
            'letters' => $letters,
            'tour' => $tour,
            'test' => $test
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Tour $tour, Test $test): Response
    {
        $variant = new Variant();

        $variant->setTest($test);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($variant);
        $entityManager->flush();

        return $this->redirectToRoute('admin_variant_index', [
            'tour' => $tour->getId(),
            'test' => $test->getId()
        ]);
    }


    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Tour $tour, Test $test, Request $request, Variant $variant): Response
    {
        $test = $variant->getTest();
        $tour = $test->getTour();

        if ($variant->getVariantQuestions()->count()){
            $this->addFlash('error', 'У варианта имеются вопросы. Необходимо их удалить');
        }elseif ($this->isCsrfTokenValid('delete' . $variant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($variant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_variant_index', [
            'tour' => $tour->getId(),
            'test' => $test->getId()
        ]);
    }
}
