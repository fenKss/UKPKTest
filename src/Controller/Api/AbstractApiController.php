<?php


namespace App\Controller\Api;


use App\Entity\Image;
use App\Entity\Question;
use App\Entity\QuestionOption;
use App\Entity\TypedField;
use App\Entity\Variant;
use App\ENum\ETypedFieldType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

/**
 * Class AbstractApiController
 *
 * @package App\Controller\Api
 */
class AbstractApiController extends AbstractController
{

    protected EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {

        $this->em = $em;
    }

    public function success($data, $statusCode = 200): JsonResponse
    {
        return $this->json([
            'error'     => false,
            'data'      => $data,
            'error_msg' => null
        ], $statusCode);
    }


    public function error(string $error_msg, $statusCode = 500): JsonResponse
    {
        return $this->json([
            'error'     => true,
            'data'      => null,
            'error_msg' => $error_msg
        ], $statusCode);
    }

    protected function __checkRequestFieldsInClass(
        array $object,
        string $class
    ): void {
        foreach ($object as $property => $value) {
            if (!property_exists($class, $property)) {
                throw new NotFoundResourceException("Property $property does not exist in $class");
            }
        }
    }

    protected function __updateRequestEntity($entity, array $requestObject)
    {
        $class = get_class($entity);
        foreach ($requestObject as $property => $value) {
            $setter = 'set' . ucfirst($property);
            if (!method_exists($entity, $setter)) {
                throw new NotFoundResourceException("Property $setter does not exist in $class");
            }
            $entity->$setter($value);
        }

    }

    protected function __getResourceFromPut(string $field)
    {
        parse_str(file_get_contents("php://input"), $post_vars);
        $resource = $post_vars[$field] ?? null;
        if (empty($resource)) {
            throw new NotFoundResourceException("$field not found in request");
        }
        return $resource;
    }

    protected function __typedFieldToArray(?TypedField $field): array
    {
        $array = [
            'type' => $field->getType(),
        ];
        switch ($field->getType()) {
            case ETypedFieldType::TEXT_TYPE:
                $array['body'] = $field->getValue();
                break;
            case ETypedFieldType::IMAGE_TYPE:
                /**@var Image $image */
                $image = $field->getImage();
                $array['body'] = [
                    'filename' => $image->getFilename(),
                    'fullPath' => $image->getFullPath(),
                ];
                break;
        }
        return $array;
    }

    protected function __optionToArray(QuestionOption $option): array
    {
        return [
            'id'         => $option->getId(),
            'questionId' => $option->getQuestion()->getId(),
            'isCorrect'  => $option->getIsCorrect(),
            'body'       => $this->__typedFieldToArray($option->getBody())
        ];
    }

    protected function __questionToArray(Question $question): array
    {
        $response = [
            'id'        => $question->getId(),
            'title'     => $this->__typedFieldToArray($question->getTitle()),
            'type'      => $question->getType(),
            'variantId' => $question->getVariant()->getId(),
            'options'   => [],
        ];
        foreach ($question->getOptions() as $option) {
            $response['options'][] = $this->__optionToArray($option);
        }
        return $response;

    }

    protected function __variantToArray(Variant $variant): array
    {
        $response = [
            'id'        => $variant->getId(),
            'testId'    => $variant->getTest()->getId(),
            'userTests' => [],
            'questions' => [],
        ];
        $userTests = $variant->getUserTests();
        foreach ($userTests as $userTest) {
            $response['userTests'][]['id'] = $userTest->getId();
        }
        $questions = $variant->getQuestions();
        foreach ($questions as $question) {
            $response['questions'][] = $this->__questionToArray($question);
        }
        return $response;
    }
}