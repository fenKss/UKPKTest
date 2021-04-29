<?php


namespace App\Controller\Api\TestEditorApi;


use App\Controller\Api\AbstractApiController;
use App\Entity\Image;
use App\Entity\QuestionOption;
use App\Entity\TypedField;
use App\lib\FS\IFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

/**
 * Class OptionController
 *
 * @Route("api/editor/option", name="api_editor_option_")
 * @package App\Controller\Api\TestEditorApi
 */
class OptionController extends AbstractApiController
{

    /**
     * @Route("/{option}", name="get", methods={"GET"})
     */
    public function getOption(QuestionOption $option): Response
    {
        return $this->success($this->__optionToArray($option));
    }

    /**
     * @Route("/{option}", name="edit", methods={"PUT"})
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
     * @Route("/{option}", name="delete", methods={"DELETE"})
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
            'body' => $this->__typedFieldToArray($option->getBody())
        ];
    }


}