<?php


namespace App\Controller\Api;


use App\Entity\Image;
use App\Entity\TypedField;
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
}