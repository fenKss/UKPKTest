<?php


namespace App\Controller;


use App\Entity\UserTest;
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
     * @return Response
     */
    public function index(UserTest $test): Response
    {

        return $this->render('test/index.html.twig', [
            'userTest' => $test
        ]);
    }
}