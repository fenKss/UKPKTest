<?php


namespace App\Controller\Admin;


use App\Entity\Variant;
use App\Repository\VariantQuestionRepository;
use App\Repository\VariantRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class VariantEditorController
 * @Route("/admin/variant/{variant}", name="admin_variant_editor_")
 *
 * @package App\Controller\Admin
 */
class VariantEditorController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Variant $variant, VariantQuestionRepository $questionRepository): Response
    {
        $questions = $questionRepository->getWithAll($variant);
        return $this->render('admin/variant_editor/index.html.twig', [
            'questions'=>$questions,
            'variant'=>$variant
        ]);
    }

    /**
     * @Route("/question/{question}", name="index_question")
     */
    public function questionIndex(Variant $variant, int $question, VariantQuestionRepository $questionRepository): Response
    {
        $questions = $questionRepository->getWithAll($variant,$question);
        return $this->render('admin/variant_editor/index.html.twig', [
            'questions'=>$questions,
            'variant'=>$variant
        ]);
    }
}