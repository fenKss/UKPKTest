<?php


namespace App\Controller\Api\TestEditorApi;


use App\Controller\Api\AbstractApiController;
use App\Entity\Question;
use App\Entity\QuestionOption;
use App\Entity\TypedField;
use App\ENum\ETypedFieldType;
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
        $option->setIsCorrect(false);
        $option->setQuestion($question);

        $value = new TypedField();
        $value->setType(ETypedFieldType::TEXT_TYPE);
        $value->setText("Вариант " . ++$optionsCount);
        $option->setBody($value);

        $this->em->persist($option);
        $this->em->persist($value);
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
}