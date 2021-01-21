<?php

namespace App\Controller;

use App\Entity\User;
use App\ENum\EUserTestStatus;
use App\Form\UserFormType;
use App\Repository\OlympRepository;
use Carbon\Carbon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @Route("/user", name="user_")
 * @package App\Controller
 */
class UserController extends AbstractController
{
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
        if (!$user){
            return $this->redirectToRoute('default');
        }
        $em = $this->getDoctrine()->getManager();
        foreach ($user->getUserTests() as $userTest){
            $tour = $userTest->getVariant()->getTest()->getTour();
            $now = new Carbon();

            if ($now > $tour->getStartedAt() && $now < $tour->getExpiredAt() && $userTest->getStatus() != EUserTestStatus::WAITING_END_TYPE){
                if ($userTest->getStatus() != EUserTestStatus::STARTED_TYPE){
                    $userTest->setStatus(EUserTestStatus::STARTED_TYPE);
                    $em->persist($userTest);
                }
            }elseif($now >= $tour->getExpiredAt()){
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
            'olymps'=>$olymps
        ]);
    }

    /**
     * @Route("/edit", name="edit")
     *
     * @return Response
     */
    public function edit(Request $request): Response
    {
        /**
         * @var ?User $user
         */
        $user = $this->getUser();
        if (!$user){
            return $this->redirectToRoute('default');
        }

        $form = $this->createForm(UserFormType::class, $user, [
            'allow_extra_fields'=>true,
            'attr'=>[
                'class'=>'form'
            ]
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute("user_index");
        }
        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form'=>$form->createView()
        ]);
    }
}
