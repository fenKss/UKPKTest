<?php


namespace App\Controller\Api\TestEditorApi;


use App\Controller\Api\AbstractApiController;
use App\Entity\Question;
use App\Entity\Variant;
use App\ENum\EQuestionTextType;
use App\ENum\EQuestionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

/**
 * Class QuestionController
 *
 * @Route("api/editor/")
 * @package App\Controller\Api\TestEditorApi
 */
class QuestionController extends AbstractApiController
{

    /**
     * @Route("question/{question}", name="question_get", methods={"GET"})
     */
    public function getQuestion(Question $question): Response
    {
        return $this->success($this->__questionToArray($question));
    }

    /**
     * @Route("variant/{variant}/question", name="question_add", methods={"POST"})
     */
    public function addQuestion(Variant $variant): Response
    {
        $question = new Question();
        $questionsCount = $variant->getQuestions()->count();
        $question->setTitleType(EQuestionTextType::TEXT_TYPE);
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
     * @Route("question/{question}", name="question_edit", methods={"PUT"})
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
     * @Route("question/{question}", name="question_delete", methods={"DELETE"})
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