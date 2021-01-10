<?php


namespace App\Controller;


use App\Entity\User;
use App\Entity\UserTest;
use App\ENum\EUserTestStatus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserTestController
 *
 * @Route("/test", name="test_")
 * @package App\Controller
 */
class UserTestController extends AbstractController
{
    /**
     * @Route("/{test}", name="index")
     * @param UserTest $test
     *
     * @return Response
     */
    public function index(UserTest $test): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        if ($user->getId() != $test->getUser()->getId()){
            return $this->redirectToRoute('user_index');
        }
        if ( $test->getStatus() != EUserTestStatus::STARTED_TYPE){
            return $this->redirectToRoute('user_index');
        }

        return $this->render('test/index.html.twig', [
            'userTest' => $test,
            'answers'=> json_decode($test->getResultJson(),true)['answers']
        ]);
    }
}