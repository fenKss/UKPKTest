<?php


namespace App\Controller\Api\TestEditorApi;


use App\Controller\Api\AbstractApiController;
use App\Entity\Question;
use App\Entity\TypedField;
use App\Entity\Variant;
use App\ENum\EQuestionType;
use App\ENum\ETypedFieldType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class VariantController
 * @Route("api/editor/variant/{variant}", name="api_editor_variant_")
 *
 * @package App\Controller\Api\TestEditorApi
 */
class VariantController extends AbstractApiController
{

    /**
     * @Route("/question", name="question_add", methods={"POST"})
     */
    public function addQuestion(Variant $variant): Response
    {
        if ($variant->getTest()->getTour()->getPublishedAt()) {
            return $this->error(self::TOUR_PUBLISHED);
        }
        $question = new Question();
        $questionsCount = $variant->getQuestions()->count();
        $question->setType(EQuestionType::RADIO_TYPE);
        $question->setVariant($variant);

        $value = new TypedField();
        $value->setType(ETypedFieldType::TEXT_TYPE);
        $value->setText("Вопрос " . ++$questionsCount);
        $question->setTitle($value);

        $this->em->persist($question);
        $this->em->persist($value);
        $this->em->flush();
        return $this->success($this->__questionToArray($question), 201);
    }

    /**
     * @Route("/questions", name="all", methods={"GET"})
     */
    public function getQuestions(Variant $variant): JsonResponse
    {
        $questions = $variant->getQuestions();

        $responseQuestions = [];
        foreach ($questions as $question) {
            $responseQuestions[] = $this->__questionToArray($question);
        }
        return $this->success($responseQuestions);

    }

    /**
     * @Route("", name="get", methods={"GET"})
     */
    public function getVariant(Variant $variant): Response
    {
        return $this->success($this->__variantToArray($variant));
    }
}