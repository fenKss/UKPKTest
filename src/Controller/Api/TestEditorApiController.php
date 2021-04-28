<?php


namespace App\Controller\Api;

use App\Entity\QuestionOption;
use App\Entity\Variant;
use App\Entity\Question;
use App\ENum\EQuestionTextType;
use App\ENum\EQuestionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Intl\Exception\MethodNotImplementedException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

/**
 * Class TestEditorApiController
 * @Route("api/editor/", name="api_editor_")
 *
 * @package App\Controller\Api
 */
class TestEditorApiController extends AbstractApiController
{

    /**
     * @Route("variant/{variant}", name="variant_get", methods={"GET"})
     */
    public function getVariant(Variant $variant): Response
    {
        return $this->success($this->__variantToArray($variant));
    }



    /**
     * @Route("option/{option}", name="option_get", methods={"GET"})
     */
    public function getOption(QuestionOption $option): Response
    {
        return $this->success($this->__optionToArray($option));
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