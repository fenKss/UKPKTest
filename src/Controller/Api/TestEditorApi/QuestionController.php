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
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

/**
 * Class QuestionController
 *
 * @Route("api/editor/question/{question}", name="api_editor_question_")
 * @package App\Controller\Api\TestEditorApi
 */
class QuestionController extends AbstractApiController
{
    protected const IMAGES_DIR = '/images/questions/title/';

    /**
     * @Route("", name="get", methods={"GET"})
     */
    public function getQuestion(Question $question): Response
    {
        return $this->success($this->__questionToArray($question));
    }

    /**
     * @Route("/option", name="option_add", methods={"POST"})
     */
    public function addOption(Question $question): Response
    {
        if ($question->getVariant()->getTest()->getTour()->getPublishedAt()){
            return $this->error(self::TOUR_PUBLISHED);
        }
        $optionsCount = $question->getOptions()->count();

        $option = new QuestionOption();
        $option->setIsCorrect(false);
        $option->setQuestion($question);

        $value = new TypedField();
        $value->setType(ETypedFieldType::TEXT_TYPE);
        $value->setText("Вариант " . ++$optionsCount);
        $value->setImage(null);
        $option->setBody($value);

        $this->em->persist($option);
        $this->em->persist($value);
        $this->em->flush();

        return $this->success($this->__optionToArray($option),
            Response::HTTP_CREATED);
    }

    /**
     * @Route("", name="edit", methods={"PUT"})
     */
    public function editQuestion(Question $question): Response
    {
        if ($question->getVariant()->getTest()->getTour()->getPublishedAt()){
            return $this->error(self::TOUR_PUBLISHED);
        }
        try {
            $questionRaw = $this->__getResourceFromPut('question');
            $this->__checkRequestFieldsInClass($questionRaw, Question::class);
            if ($questionRaw['type'] == EQuestionType::RADIO_TYPE
                && $question->getType() == EQuestionType::SELECT_TYPE
            ) {
                $this->__setFirstOptionCorrect($question);
            }
            $this->__updateRequestEntity($question, $questionRaw);
            $this->em->persist($question);
            $this->em->flush();
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        return $this->success($this->__questionToArray($question),
            Response::HTTP_OK);
    }

    /**
     * @Route("/title", name="edit_title", methods={"POST", "PUT"})
     */
    public function editQuestionTitle(
        Question $question,
        Request $request
    ): Response {
        if ($question->getVariant()->getTest()->getTour()->getPublishedAt()){
            return $this->error(self::TOUR_PUBLISHED);
        }
        try {
            $imageTitle = $request->files->get('title');
            if ($imageTitle) {
                $this->__updateTypedTitleImage($question->getTitle(),
                    $imageTitle);
            } else {
                $this->__updateTypedTitleText($question->getTitle(), $request,
                    'question');
            }
            $this->em->persist($question);
            $this->em->flush();
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        return $this->success($this->__questionToArray($question),
            Response::HTTP_OK);
    }

    /**
     * @Route("", name="delete", methods={"DELETE"})
     */
    public function deleteQuestion(Question $question): Response
    {
        if ($question->getVariant()->getTest()->getTour()->getPublishedAt()){
            return $this->error(self::TOUR_PUBLISHED);
        }
        $this->em->remove($question);
        $this->em->flush();
        return $this->success(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * При смене типа с Select на Radio выставляем правильную опцию первую попавшуюся
     */
    private function __setFirstOptionCorrect(Question $question)
    {
        $firstCorrect = $question->getOptions()->filter(function ($option) {
            /** @var QuestionOption $option */
            return $option->getIsCorrect();
        })->first();
        //При смене на радио тип выствляем корректным только первый корректный option который мы найдем
        if ($firstCorrect instanceof QuestionOption) {
            foreach ($question->getOptions() as $option) {
                $option->setIsCorrect(false);
                $this->em->persist($option);
            }
            $firstCorrect->setIsCorrect(true);
            $this->em->persist($firstCorrect);
        } else {
            //Мы не нашли корректный и ставим первый попавшийся
            $first = $question->getOptions()->first();
            if ($first instanceof QuestionOption) {
                $first->setIsCorrect(true);
                $this->em->persist($first);
            }
        }
    }

}