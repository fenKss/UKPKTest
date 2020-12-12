<?php


namespace App\Controller\Api;

use App\Entity\QuestionOption;
use App\Entity\Variant;
use App\Entity\VariantQuestion;
use App\ENum\EQuestionType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TestEditorApiController
 * @Route("api/variant/{variant}", name="api_variant_")
 *
 * @package App\Controller\Api
 */
class TestEditorApiController extends AbstractApiController
{
    /**
     * @Route("/question/add", name="add_question")
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function addQuestion(Variant $variant, Request $request)
    {
        $question = new VariantQuestion();

        $questions = $variant->getVariantQuestions();
        $question->setText('Вопрос ' . ($questions->count() + 1));
        $question->setType(EQuestionType::RADIO_TYPE);
        $question->setVariant($variant);

        $em = $this->getDoctrine()->getManager();

        $em->persist($question);
        $em->flush();

        return $this->success([
            'id' => $question->getId()
        ]);
    }
}