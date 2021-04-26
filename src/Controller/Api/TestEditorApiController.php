<?php


namespace App\Controller\Api;

use App\Entity\QuestionOption;
use App\Entity\Variant;
use App\Entity\Question;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class TestEditorApiController
 * @Route("api/editor/", name="api_editor_")
 *
 * @package App\Controller\Api
 */
class TestEditorApiController extends AbstractApiController
{

    public function __construct(SerializerInterface $serializer)
    {
    }

    /**
     * @Route("variant/{variant}", name="variant", methods={"GET"})
     */
    public function getVariant(Variant $variant): Response
    {
        return $this->success($this->__variantToArray($variant));
    }

    /**
     * @Route("question/{question}", name="question", methods={"GET"})
     */
    public function getQuestion(Question $question): Response
    {
        return $this->success($this->__questionToArray($question));
    }

    /**
     * @Route("option/{option}", name="option", methods={"GET"})
     */
    public function getOption(QuestionOption $option): Response
    {
        return $this->success($this->__optionToArray($option));
    }

    private function __questionToArray(Question $question): array
    {
        $response = [
            'id'        => $question->getId(),
            'title'     => $question->getTitle(),
            'titleType' => $question->getTitleType(),
            'variantId' => $question->getVariant()->getId(),
            'options'   => [],
        ];
        foreach ($question->getOptions() as $option) {
            $response['options'][]['id'] = $option->getId();
        }
        return $response;

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

    private function __optionToArray(QuestionOption $option): array
    {
        return [
            'id'         => $option->getId(),
            'questionId' => $option->getQuestion()->getId(),
            'isCorrect'  => $option->getIsCorrect(),
            'text'       => $option->getText(),
            'type'       => $option->getType()
        ];
    }
}