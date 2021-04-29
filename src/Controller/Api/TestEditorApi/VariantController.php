<?php


namespace App\Controller\Api\TestEditorApi;


use App\Controller\Api\AbstractApiController;
use App\Entity\Question;
use App\Entity\TypedField;
use App\Entity\Variant;
use App\ENum\EQuestionType;
use App\ENum\ETypedFieldType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class VariantController
 * @Route("api/editor/variant", name="api_editor_variant_")
 *
 * @package App\Controller\Api\TestEditorApi
 */
class VariantController extends AbstractApiController
{
    private UrlGeneratorInterface $generator;

    public function __construct(EntityManagerInterface $em, UrlGeneratorInterface $generator)
    {
        parent::__construct($em);
        $this->generator = $generator;
    }

    /**
     * @Route("/{variant}/question", name="question_add", methods={"POST"})
     */
    public function addQuestion(Variant $variant): Response
    {
        $question = new Question();
        $questionsCount = $variant->getQuestions()->count();
        $question->setType(EQuestionType::RADIO_TYPE);
        $question->setVariant($variant);

        $value = new TypedField();
        $value->setType(ETypedFieldType::TEXT_TYPE);
        $value->setText("Вопрос " . ++$questionsCount);
        $question->setTitle($value);

        $this->em->persist($question);
        $this->em->persist($value);
        $this->em->flush();
        return $this->success([
            'id' => $question->getId()
        ], 201);
    }

    /**
     * @Route("/{variant}", name="get", methods={"GET"})
     */
    public function getVariant(Variant $variant): Response
    {
        return $this->success($this->__variantToArray($variant));
    }


}