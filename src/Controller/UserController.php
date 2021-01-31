<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\User;
use App\ENum\EQuestionTextType;
use App\ENum\EUserTestStatus;
use App\Form\UserFormType;
use App\lib\FS\Exceptions\FileNotExistException;
use App\lib\FS\FS;
use App\Repository\OlympRepository;
use Carbon\Carbon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\u;

/**
 * Class UserController
 * @Route("/user", name="user_")
 *
 * @package App\Controller
 */
class UserController extends AbstractController
{
    private CONST AVATAR_DIR = '/images/avatars/';
    private string $projectPublicDir;

    public function __construct(string $projectDir){
        $this->projectPublicDir = $projectDir."/public";
    }


    /**
     * @Route("/", name="index")
     * @param OlympRepository $olympRepository
     *
     * @return Response
     */
    public function index(OlympRepository $olympRepository): Response
    {
        /**
         * @var ?User $user
         */
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('default');
        }
        $em = $this->getDoctrine()->getManager();
        foreach ($user->getUserTests() as $userTest) {
            $tour = $userTest->getVariant()->getTest()->getTour();
            $now = new Carbon();

            if ($now > $tour->getStartedAt() && $now < $tour->getExpiredAt() && $userTest->getStatus() != EUserTestStatus::WAITING_END_TYPE) {
                if ($userTest->getStatus() != EUserTestStatus::STARTED_TYPE) {
                    $userTest->setStatus(EUserTestStatus::STARTED_TYPE);
                    $em->persist($userTest);
                }
            } elseif ($now >= $tour->getExpiredAt()) {
                if ($userTest->getStatus() != EUserTestStatus::FINISHED_TYPE) {
                    $userTest->setStatus(EUserTestStatus::FINISHED_TYPE);
                    $em->persist($userTest);
                }
            }
        }
        $em->flush();
        $olymps = $olympRepository->getByUser($user);

        return $this->render('user/index.html.twig', [
            'user' => $user,
            'olymps' => $olymps
        ]);
    }

    /**
     * @Route("/edit", name="edit")
     *
     * @param Request $request
     *
     * @return Response
     * @throws FileNotExistException
     */
    public function edit(Request $request): Response
    {
        /**
         * @var ?User $user
         */
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('default');
        }

        $form = $this->createForm(UserFormType::class, $user, [
            'allow_extra_fields' => true,
            'attr' => [
                'class' => 'form'
            ]
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $avatarFile = $form->get('avatarFile')->getData();
            //just 1 file in array
            if ($avatarFile && isset($avatarFile[0])) {
                /**
                 * @var UploadedFile $avatarFile
                 */
                $avatarFile = $avatarFile[0];

                $image = new Image();

                $filename = FS::generateRandomString(15);
                $extension = explode(".", $avatarFile->getClientOriginalName());
                $extension = end($extension);
                $path = ( self::AVATAR_DIR . $filename . "." . $extension);

                $fullPathDir = $this->projectPublicDir.self::AVATAR_DIR;
                $fullPath = $this->projectPublicDir.$path;

                if (!FS::isDir( $fullPathDir)) {
                    FS::mkdir( $fullPathDir);
                }
                $image->setSize($avatarFile->getFileInfo()->getSize());
                $image->setFilename($filename);
                $image->setPath($path);
                $image->setFullPath($this->projectPublicDir.$path);
                $image->setType(EQuestionTextType::AVATAR_TYPE);
                $image->setExtension($extension);

                if (move_uploaded_file($avatarFile->getRealPath(), $fullPath)) {
                    $userAvatar = $user->getAvatar();
                    if ($userAvatar){
                        $user->setAvatar(null);
                        $em->persist($user);
                        $em->remove($userAvatar);

                        FS::rm($userAvatar->getFullPath());

                    }

                    $user->setAvatar($image);
                    $em->persist($image);
                } else {
                    return $this->render('user/edit.html.twig', [
                        'user' => $user,
                        'form' => $form->createView(),
                        'error' => 'не удалось загрузить аватар'
                    ]);
                }

            }
            $em->persist($user);
            $em->flush();


            return $this->redirectToRoute("user_index");
        }
        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'error'=>''
        ]);
    }
}
