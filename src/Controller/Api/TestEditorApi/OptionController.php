<?php


namespace App\Controller\Api\TestEditorApi;


use App\Controller\Api\AbstractApiController;
use App\Entity\Question;
use App\Entity\QuestionOption;
use App\ENum\EOptionType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

/**
 * Class OptionController
 *
 * @Route("api/editor/")
 * @package App\Controller\Api\TestEditorApi
 */
class OptionController extends AbstractApiController
{

    /**
     * @Route("option/{option}", name="option_get", methods={"GET"})
     */
    public function getOption(QuestionOption $option): Response
    {
        return $this->success($this->__optionToArray($option));
    }

    /**
     * @Route("question/{question}/option", name="option_add", methods={"POST"})
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
     * @Route("option/{option}", name="option_edit", methods={"PUT"})
     */
    public function editOption(QuestionOption $option): Response
    {
        try {
            $optionRaw = $this->__getResourceFromPut('option');
            $this->__checkRequestFieldsInClass($optionRaw, QuestionOption::class);
            $this->__updateRequestEntity($option, $optionRaw);
            $this->em->persist($option);
            $this->em->flush();
        } catch (NotFoundResourceException $e) {
            return $this->error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        return $this->success(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("option/{option}", name="option_delete", methods={"DELETE"})
     */
    public function deleteOption(QuestionOption $option): Response
    {
        $this->em->remove($option);
        $this->em->flush();
        return $this->success(null, Response::HTTP_NO_CONTENT);
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