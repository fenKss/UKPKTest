<?php


namespace App\Controller\Api\TestEditorApi;


use App\Controller\Api\AbstractApiController;
use App\Entity\Question;
use App\Entity\QuestionOption;
use App\Entity\Variant;
use App\ENum\EOptionType;
use App\ENum\EQuestionType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

/**
 * Class QuestionController
 *
 * @Route("api/editor/question", name="api_editor_question_")
 * @package App\Controller\Api\TestEditorApi
 */
class QuestionController extends AbstractApiController
{

    /**
     * @Route("/{question}", name="get", methods={"GET"})
     */
    public function getQuestion(Question $question): Response
    {
        return $this->success($this->__questionToArray($question));
    }

    /**
     * @Route("/{question}/option", name="option_add", methods={"POST"})
     */
    public function addOption(Question $question): Response
    {
        $option = new QuestionOption();
        $optionsCount = $question->getOptions()->count();
        $option->setType(EOptionType::TEXT_TYPE);
        $option->setIsCorrect(false);
        $option->setQuestion($question);
        $option->setText("Вариант " . ++$optionsCount);

        $this->em->persist($option);
        $this->em->flush();
        return $this->success([
            'id' => $option->getId()
        ], 201);
    }

    /**
     * @Route("/{question}", name="edit", methods={"PUT"})
     */
    public function editQuestion(Question $question): Response
    {
        try {
            $questionRaw = $this->__getResourceFromPut('question');
            $this->__checkRequestFieldsInClass($questionRaw, Question::class);
            $this->__updateRequestEntity($question, $questionRaw);
            $this->em->persist($question);
            $this->em->flush();
        } catch (NotFoundResourceException $e) {
            return $this->error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        return $this->success(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/{question}", name="delete", methods={"DELETE"})
     */
    public function deleteQuestion(Question $question): Response
    {
        $this->em->remove($question);
        $this->em->flush();
        return $this->success(null, Response::HTTP_NO_CONTENT);
    }

    public static function __questionToArray(Question $question): array
    {
        $response = [
            'id'        => $question->getId(),
            'title'     => $question->getTitle(),
            'titleType' => $question->getTitleType(),
            'type'      => $question->getType(),
            'variantId' => $question->getVariant()->getId(),
            'options'   => [],
        ];
        foreach ($question->getOptions() as $option) {
            $response['options'][]['id'] = $option->getId();
        }
        return $response;

    }
}