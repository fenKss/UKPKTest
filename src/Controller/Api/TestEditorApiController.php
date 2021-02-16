<?php


namespace App\Controller\Api;

use App\Entity\PossibleAnswer;
use App\Entity\Variant;
use App\Entity\Question;
use App\ENum\EQuestionTextType;
use App\ENum\EQuestionType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TestEditorApiController
 * @Route("api/variant/{variant}", name="api_variant_")
 *
 * @package App\Controller\Api
 */
class TestEditorApiController extends AbstractApiController
{
    /**
     * @Route("/question/", name="index")
     * @param Variant $variant
     *
     * @return JsonResponse
     */
    public function getAll(Variant $variant): JsonResponse
    {
        return $this->success($this->_getQuestionsAsArray($variant));
    }

    /**
     * @Route("/question/add", name="add_question")
     * @param Variant $variant
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function addQuestion(Variant $variant, Request $request): JsonResponse
    {
        $question = new Question();

        $questions = $variant->getQuestions();
        $question->setTitle('Вопрос ' . ($questions->count() + 1));
        $question->setType(EQuestionType::RADIO_TYPE);
        $question->setVariant($variant);
        $question->setTitleType(EQuestionTextType::TEXT_TYPE);
        $em = $this->getDoctrine()->getManager();

        $em->persist($question);
        $em->flush();

        return $this->success([
            'id' => $question->getId()
        ]);
    }

    /**
     * @Route("/question/{question}/edit/title", name="edit_question_title")
     * @param Variant  $variant
     * @param Question $question
     * @param Request  $request
     *
     * @return JsonResponse
     */
    public function editQuestionTitle(Variant $variant, Question $question, Request $request): JsonResponse
    {
        $title = $request->get('title');
        if (!$title) {
            return $this->error('title required');
        }
        $question->setTitle($title);
        $em = $this->getDoctrine()->getManager();

        $em->persist($question);
        $em->flush();

        return $this->success([
            'id' => $question->getId()
        ]);
    }

    /**
     * /**
     * @Route("/question/{question}/edit/type", name="edit_question_type")
     * @param Variant  $variant
     * @param Question $question
     * @param Request  $request
     *
     * @return JsonResponse
     */
    public function editQuestionType(Variant $variant, Question $question, Request $request): JsonResponse
    {
        $typeRaw = $request->get('type');
        if (is_null($typeRaw)) {
            return $this->error('type required');
        }
        $type = $typeRaw ? EQuestionType::RADIO_TYPE : EQuestionType::SELECT_TYPE;
        $question->setType($type);
        $em = $this->getDoctrine()->getManager();

        $em->persist($question);
        if ($type == EQuestionType::RADIO_TYPE) {
            $options = $question->getPossibleAnswers();
            $firstOption = null;
            foreach ($options as $option) {
                if ($option->getIsCorrect()) {
                    $firstOption = $option;
                    break;
                }
            }
            foreach ($options as $option) {
                if ($option->getIsCorrect()) {
                    $option->setIsCorrect(false);
                    $em->persist($option);
                }
            }
            if ($firstOption) {
                $firstOption->setIsCorrect(true);
                $em->persist($firstOption);
            }

        }
        $em->flush();

        return $this->success([
            'id' => $question->getId()
        ]);
    }

    /**
     * @Route("/question/{question}/option/add", name="add_question_option")
     * @param Variant  $variant
     * @param Question $question
     * @param Request  $request
     *
     * @return JsonResponse
     */
    public function addOption(Variant $variant, Question $question, Request $request): JsonResponse
    {
        $option = new PossibleAnswer();

        $options = $question->getPossibleAnswers();
        $option->setText('Вариант ' . ($options->count() + 1));
        $option->setQuestion($question);
        $option->setIsCorrect(false);

        $em = $this->getDoctrine()->getManager();

        $em->persist($option);
        $em->flush();

        return $this->success([
            'id' => $option->getId()
        ]);
    }

    /**
     * @Route("/question/{question}/option/{option}/correct", name="question_option_edit_correct")
     * @param Variant        $variant
     * @param Question       $question
     * @param PossibleAnswer $option
     *
     * @return JsonResponse
     */
    public function editCorrectOption(Variant $variant, Question $question, PossibleAnswer $option): JsonResponse
    {
        $type = $question->getType();
        $em = $this->getDoctrine()->getManager();
        switch ($type) {
            case EQuestionType::RADIO_TYPE()->getValue():
                $options = $question->getPossibleAnswers();
                foreach ($options as $questionOption) {
                    $questionOption->setIsCorrect(false);
                    $em->persist($option);
                }
                break;
            case EQuestionType::SELECT_TYPE()->getValue():
                $option->setIsCorrect(!$option->getIsCorrect());
                $em->persist($option);
                break;
        }
        $em->flush();
        return $this->success([
            'id' => $option->getId()
        ]);
    }

    /**
     * @Route("/question/{question}/option/{option}/edit/title", name="question_option_edit_title")
     * @param Variant        $variant
     * @param PossibleAnswer $option
     * @param Question       $question
     * @param Request        $request
     *
     * @return JsonResponse
     */
    public function editOptionTitle(
        Variant $variant,
        PossibleAnswer $option,
        Question $question,
        Request $request
    ): JsonResponse {
        $title = $request->get('title');
        if (!$title) {
            return $this->error('title required');
        }
        $option->setText($title);
        $em = $this->getDoctrine()->getManager();

        $em->persist($question);
        $em->flush();

        return $this->success([
            'id' => $option->getId()
        ]);
    }

    /**
     * @param Variant $variant
     *
     * @return array
     */
    private function _getQuestionsAsArray(Variant $variant): array
    {
        $returnData = [];

        $questions = $variant->getQuestions();
        foreach ($questions as $question) {
            $returnData[$question->getId()] = $this->_getQuestionWithOptionsAsArray($question);
        }
        return $returnData;
    }

    /**
     * @param Question $question
     *
     * @return array
     */
    private function _getQuestionWithOptionsAsArray(Question $question): array
    {
        $questionArray = [
            'id' => $question->getId(),
            'title' => $question->getTitle(),
            'options' => []
        ];
        $options = $question->getPossibleAnswers();
        foreach ($options as $option) {
            $questionArray['options'][$option->getId()] = $this->_getOptionAsArray($option);
        }
        return  $questionArray;
    }

    /**
     * @param PossibleAnswer $option
     *
     * @return array
     */
    private function _getOptionAsArray(PossibleAnswer $option): array
    {
       return [
           'id' => $option->getId(),
           'text' => $option->getText(),
           'isCorrect' => $option->getIsCorrect()
       ];
    }
}