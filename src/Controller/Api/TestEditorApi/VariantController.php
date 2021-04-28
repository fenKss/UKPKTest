<?php


namespace App\Controller\Api\TestEditorApi;


use App\Controller\Api\AbstractApiController;
use App\Entity\Question;
use App\Entity\Variant;
use App\ENum\EOptionType;
use App\ENum\EQuestionType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class VariantController
 * @Route("api/editor/variant", name="api_editor_variant_")
 *
 * @package App\Controller\Api\TestEditorApi
 */
class VariantController extends AbstractApiController
{
    /**
     * @Route("/{variant}/question", name="question_add", methods={"POST"})
     */
    public function addQuestion(Variant $variant): Response
    {
        $question = new Question();
        $questionsCount = $variant->getQuestions()->count();
        $question->setTitleType(EOptionType::TEXT_TYPE);
        $question->setType(EQuestionType::RADIO_TYPE);
        $question->setVariant($variant);
        $question->setTitle("Вопрос " . ++$questionsCount);

        $this->em->persist($question);
        $this->em->flush();
        return $this->success([
            'id' => $question->getId()
        ], 201);
    }

    /**
     * @Route("/{variant}", name="get", methods={"GET"})
     */
    public function getVariant(Variant $variant): Response
    {
        return $this->success($this->__variantToArray($variant));
    }

    private function __variantToArray(Variant $variant): array
    {
        $response = [
            'id'     => $variant->getId(),
            'testId' => $variant->getTest()->getId(),
        ];
        $userTests = $variant->getUserTests();
        foreach ($userTests as $userTest) {
            $response['userTests'][]['id'] = $userTest->getId();
        }
        $questions = $variant->getQuestions();
        foreach ($questions as $question) {
            $response['questions'][]['id'] = $question->getId();
        }
        return $response;
    }
}