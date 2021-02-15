<?php


namespace App\Controller\Admin;


use App\Entity\Variant;
use App\Repository\QuestionRepository;
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
     * @Route("/react", name="index_react")
     */
    public function indexReact(Variant $variant, QuestionRepository $questionRepository): Response
    {
        $questions = $questionRepository->getWithAll($variant);
        return $this->render('admin/variant_editor/react.index.html.twig', [
            'questions'=>$questions,
            'variant'=>$variant
        ]);
    }

    /**
     * @Route("/", name="index")
     * @param Variant            $variant
     * @param QuestionRepository $questionRepository
     *
     * @return Response
     */
    public function index(Variant $variant, QuestionRepository $questionRepository): Response
    {
        $questions = $questionRepository->getWithAll($variant);
        return $this->render('admin/variant_editor/index.html.twig', [
            'questions'=>$questions,
            'variant'=>$variant
        ]);
    }

    /**
     * @Route("/question/{question}", name="index_question")
     * @param Variant                   $variant
     * @param int                       $question
     * @param QuestionRepository $questionRepository
     *
     * @return Response
     */
    public function questionIndex(Variant $variant, int $question, QuestionRepository $questionRepository): Response
    {
        $questions = $questionRepository->getWithAll($variant,$question);
        return $this->render('admin/variant_editor/index.html.twig', [
            'questions'=>$questions,
            'variant'=>$variant
        ]);
    }
}