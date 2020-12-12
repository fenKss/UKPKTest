<?php


namespace App\Controller\Api;

use App\Entity\QuestionOption;
use App\Entity\Variant;
use App\Entity\VariantQuestion;
use App\ENum\EQuestionType;
use Symfony\Component\Console\Question\Question;
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
     * @Route("/question/add", name="add_question")
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function addQuestion(Variant $variant, Request $request): JsonResponse
    {
        $question = new VariantQuestion();

        $questions = $variant->getVariantQuestions();
        $question->setText('Вопрос ' . ($questions->count() + 1));
        $question->setType(EQuestionType::RADIO_TYPE);
        $question->setVariant($variant);

        $em = $this->getDoctrine()->getManager();

        $em->persist($question);
        $em->flush();

        return $this->success([
            'id' => $question->getId()
        ]);
    }

    /**
     * @Route("/question/{question}/edit/title", name="edit_question_title")
     * @param Variant         $variant
     * @param VariantQuestion $question
     * @param Request         $request
     *
     * @return JsonResponse
     */
    public function editQuestionTitle(Variant $variant, VariantQuestion $question, Request $request): JsonResponse
    {
        $title = $request->get('title');
        if (!$title){
            return $this->error('title required');
        }
        $question->setText($title);
        $em = $this->getDoctrine()->getManager();

        $em->persist($question);
        $em->flush();

        return $this->success([
            'id' => $question->getId()
        ]);
    }

    /**
     * @Route("/question/{question}/option/add", name="add_question_option")
     * @param Variant         $variant
     * @param VariantQuestion $question
     * @param Request         $request
     *
     * @return JsonResponse
     */
    public function addOption(Variant $variant, VariantQuestion $question, Request $request): JsonResponse
    {
        $option = new QuestionOption();

        $options = $question->getQuestionOptions();
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
}