<?php


namespace App\Controller\Api\TestEditorApi;


use App\Controller\Api\AbstractApiController;
use App\Entity\Image;
use App\Entity\Question;
use App\Entity\QuestionOption;
use App\Entity\TypedField;
use App\ENum\EImageType;
use App\ENum\ETypedFieldType;
use App\lib\FS\Exceptions\FileNotExistException;
use App\lib\FS\FS;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

/**
 * Class QuestionController
 *
 * @Route("api/editor/question", name="api_editor_question_")
 * @package App\Controller\Api\TestEditorApi
 */
class QuestionController extends AbstractApiController
{
    private const IMAGES_DIR = '/images/questions/title/';
    private string $projectPublicDir;

    public function __construct(EntityManagerInterface $em, string $projectDir)
    {
        parent::__construct($em);
        $this->projectPublicDir = $projectDir . "/public";
    }


    /**
     * @Route("/{question}", name="get", methods={"GET"})
     */
    public function getQuestion(Question $question): Response
    {
        return $this->success($this->__questionToArray($question));
    }

    /**
     * @Route("/{question}/option", name="option_add", methods={"POST"})
     */
    public function addOption(Question $question): Response
    {
        $option = new QuestionOption();
        $optionsCount = $question->getOptions()->count();
        $option->setIsCorrect(false);
        $option->setQuestion($question);

        $value = new TypedField();
        $value->setType(ETypedFieldType::TEXT_TYPE);
        $value->setText("Вариант " . ++$optionsCount);
        $option->setBody($value);

        $this->em->persist($option);
        $this->em->persist($value);
        $this->em->flush();

        return $this->success($this->__optionToArray($option),
            Response::HTTP_CREATED);
    }

    /**
     * @Route("/{question}", name="edit", methods={"PUT"})
     */
    public function editQuestion(Question $question): Response
    {
        try {
            $questionRaw = $this->__getResourceFromPut('question');
            $this->__checkRequestFieldsInClass($questionRaw, Question::class);
            $this->__updateRequestEntity($question, $questionRaw);
            $this->em->persist($question);
            $this->em->flush();
        } catch (NotFoundResourceException $e) {
            return $this->error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        return $this->success($this->__questionToArray($question), Response::HTTP_OK);
    }

    /**
     * @Route("/{question}/title", name="edit_title", methods={"POST", "PUT"})
     */
    public function editQuestionTitle(
        Question $question,
        Request $request
    ): Response {
        try {
            $imageTitle = $request->files->get('title');
            if ($imageTitle) {
                $error = $this->__updateQuestionTitleImage($question,
                    $imageTitle);
            } else {
                $error = $this->__updateQuestionTitleText($question, $request);
            }
            if ($error instanceof JsonResponse) {
                return $error;
            }
            $this->em->persist($question);
            $this->em->flush();
        } catch (NotFoundResourceException  | FileNotExistException $e) {
            return $this->error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        return $this->success($this->__questionToArray($question), Response::HTTP_OK);
    }

    /**
     * @Route("/{question}", name="delete", methods={"DELETE"})
     */
    public function deleteQuestion(Question $question): Response
    {
        $this->em->remove($question);
        $this->em->flush();
        return $this->success(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @return false|JsonResponse
     * @throws FileNotExistException
     */
    private function __updateQuestionTitleImage(
        Question $question,
        File $imageTitle
    ) {
        $image = new Image();

        $filename = FS::generateRandomString(15);
        $extension = explode(".", $imageTitle->getClientOriginalName());
        $extension = end($extension);
        $path = (self::IMAGES_DIR . $filename . "." . $extension);

        $fullPathDir = $this->projectPublicDir . self::IMAGES_DIR;
        $fullPath = $this->projectPublicDir . $path;

        if (!FS::isDir($fullPathDir)) {
            FS::mkdir($fullPathDir);
        }
        $image->setSize($imageTitle->getFileInfo()->getSize());
        $image->setFilename($filename);
        $image->setPath($path);
        $image->setFullPath($this->projectPublicDir . $path);
        $image->setType(EImageType::TITLE_TYPE);
        $image->setExtension($extension);

        if (move_uploaded_file($imageTitle->getRealPath(), $fullPath)) {
            $questionTitle = $question->getTitle();

            if ($questionTitle->getType() == ETypedFieldType::IMAGE_TYPE) {
                $this->__deleteOldQuestionImageTitle($questionTitle);

            }
            $questionTitle->setImage($image);
            $questionTitle->setType(ETypedFieldType::IMAGE_TYPE);
            $this->em->persist($image);
            $this->em->persist($questionTitle);

        } else {
            return $this->error('Cant load file');
        }
        return false;
    }

    /**
     * @throws FileNotExistException
     */
    private function __updateQuestionTitleText(
        Question $question,
        Request $request
    ) {
        $questionRaw = $this->__getResourceFromPut('question');
        if (!isset($questionRaw['title']['body'])) {
            return $this->error("Invalid question title text",
                Response::HTTP_BAD_REQUEST);
        }
        $questionTitle = $question->getTitle();
        $questionTitle->setType(ETypedFieldType::TEXT_TYPE);
        $questionTitle->setText($questionRaw['title']['body']);
        $this->__deleteOldQuestionImageTitle($questionTitle);
        $questionTitle->setImage(null);
        $this->em->persist($questionTitle);
        return false;
    }

    /**
     * @throws FileNotExistException
     */
    private function __deleteOldQuestionImageTitle(TypedField $questionTitle)
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

}