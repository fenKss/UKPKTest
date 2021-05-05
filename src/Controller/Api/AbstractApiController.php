<?php


namespace App\Controller\Api;


use App\Entity\Image;
use App\Entity\Question;
use App\Entity\QuestionOption;
use App\Entity\TypedField;
use App\Entity\Variant;
use App\ENum\EImageType;
use App\ENum\ETypedFieldType;
use App\lib\FS\Exceptions\FileNotExistException;
use App\lib\FS\FS;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

/**
 * Class AbstractApiController
 *
 * @package App\Controller\Api
 */
class AbstractApiController extends AbstractController
{
    protected const IMAGES_DIR = '/images/title/';
    protected EntityManagerInterface $em;
    protected string                 $projectPublicDir;

    public function __construct(EntityManagerInterface $em, string $projectDir)
    {

        $this->em = $em;
        $this->projectPublicDir = $projectDir . "/public";
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
            if (!property_exists($class, $property)
                && !strpos($property, 'Id')
            ) {
                throw new NotFoundResourceException("Property $property does not exist in $class");
            }
        }
    }

    protected function __updateRequestEntity($entity, array $requestObject)
    {
        foreach ($requestObject as $property => $value) {
            $setter = 'set' . ucfirst($property);
            if (method_exists($entity, $setter) && !is_array($value)) {
                $entity->$setter($value);
            }

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
                    'fullPath' => $image->getPath(),
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

    /**
     * @throws FileNotExistException
     */
    protected function __deleteOldTypedFieldImage(TypedField $questionTitle)
    {
        if ($questionTitle->getType() == ETypedFieldType::IMAGE_TYPE
            || $questionTitle->getImage()
        ) {
            $oldImage = $questionTitle->getImage();
            if (Fs::isFileExist($oldImage->getFullPath())) {
                FS::rm($oldImage->getFullPath());
            }
            $questionTitle->setImage(null);
            $this->em->persist($questionTitle);
            $this->em->remove($oldImage);
        }
    }


    protected function __generateImageFromFile(File $file): Image
    {
        $image = new Image();

        $filename = FS::generateRandomString(15);
        $extension = explode(".", $file->getClientOriginalName());
        $extension = end($extension);
        $path = (self::IMAGES_DIR . $filename . "." . $extension);

        $fullPathDir = $this->projectPublicDir . self::IMAGES_DIR;
        $fullPath = $this->projectPublicDir . $path;

        if (!FS::isDir($fullPathDir)) {
            FS::mkdir($fullPathDir);
        }
        $image->setSize($file->getFileInfo()->getSize());
        $image->setFilename($filename);
        $image->setPath($path);
        $image->setFullPath($this->projectPublicDir . $path);
        $image->setType(EImageType::TITLE_TYPE);
        $image->setExtension($extension);

        if (!move_uploaded_file($file->getRealPath(), $fullPath)) {
            throw new RuntimeException("Can't upload file on server");
        }


        $this->em->persist($image);
        return $image;
    }

    /**
     *
     * @throws FileNotExistException
     */
    protected function __updateTypedTitleText(
        TypedField $title,
        Request $request,
        string $field
    ): bool {
        $titleRaw = $this->__getResourceFromPut($field);
        if (!isset($titleRaw['title']['body'])) {
            throw new RuntimeException("Invalid title text");
        }
        $title->setType(ETypedFieldType::TEXT_TYPE);
        $title->setText($titleRaw['title']['body']);
        $this->__deleteOldTypedFieldImage($title);
        $title->setImage(null);
        $this->em->persist($title);
        return false;
    }

    /**
     * @throws FileNotExistException
     */
    protected function __updateTypedTitleImage(
        TypedField $title,
        File $imageTitle
    ) {
        $image = $this->__generateImageFromFile($imageTitle);

        if ($title->getType() == ETypedFieldType::IMAGE_TYPE) {
            $this->__deleteOldTypedFieldImage($title);
        }
        $title->setImage($image);
        $title->setType(ETypedFieldType::IMAGE_TYPE);
        $this->em->persist($image);
        $this->em->persist($title);

    }

}