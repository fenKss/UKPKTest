<?php


namespace App\Controller\Api\TestEditorApi;


use App\Controller\Api\AbstractApiController;
use App\Entity\Image;
use App\Entity\Question;
use App\Entity\QuestionOption;
use App\Entity\TypedField;
use App\ENum\EImageType;
use App\ENum\EQuestionType;
use App\ENum\ETypedFieldType;
use App\lib\FS\Exceptions\FileNotExistException;
use App\lib\FS\FS;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

/**
 * Class OptionController
 *
 * @Route("api/editor/option/{option}", name="api_editor_option_")
 * @package App\Controller\Api\TestEditorApi
 */
class OptionController extends AbstractApiController
{
    protected const IMAGES_DIR = '/images/options/title/';

    /**
     * @Route("", name="get", methods={"GET"})
     */
    public function getOption(QuestionOption $option): Response
    {
        return $this->success($this->__optionToArray($option));
    }

    /**
     * @Route("", name="edit", methods={"PUT"})
     */
    public function editOption(QuestionOption $option): Response
    {
        try {
            $optionRaw = $this->__getResourceFromPut('option');
            $this->__checkRequestFieldsInClass($optionRaw, QuestionOption::class);
            $this->__updateRequestEntity($option, $optionRaw);
            if ($option->getQuestion()->getType() == EQuestionType::RADIO_TYPE && $option->getIsCorrect()){
                $options = $option->getQuestion()->getOptions();
                foreach ($options as $questionOption){
                    if ($questionOption->getId() != $option->getId()){
                        $questionOption->setIsCorrect(false);
                        $this->em->persist($questionOption);
                    }

                }
            }
            $this->em->persist($option);
            $this->em->flush();
        } catch (NotFoundResourceException $e) {
            return $this->error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        return $this->success($this->__optionToArray($option), Response::HTTP_OK);
    }

    /**
     * @Route("", name="delete", methods={"DELETE"})
     */
    public function deleteOption(QuestionOption $option): Response
    {
        $this->em->remove($option);
        $this->em->flush();
        return $this->success(null, Response::HTTP_NO_CONTENT);
    }



    /**
     * @return false|JsonResponse
     */
    private function __updateOptionTitleImage(
        QuestionOption $option,
        File $imageTitle
    )
    {
        try {
            $image = $this->__generateImageFromFile($imageTitle);

            $body = $option->getBody();
            if ($body->getType() == ETypedFieldType::IMAGE_TYPE) {
                $this->__deleteOldTypedFieldImage($body);
            }

            $body->setImage($image);
            $body->setType(ETypedFieldType::IMAGE_TYPE);
            $this->em->persist($image);
            $this->em->persist($body);

        } catch (\Throwable $e) {
            return $this->error('Cant load file' . $e->getMessage());
        }
        return false;
    }




}