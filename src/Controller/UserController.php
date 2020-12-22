<?php

namespace App\Controller;

use App\Repository\OlympRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        $user = $this->getUser();
        $olymps = $olympRepository->getByUser($user);

        return $this->render('user/index.html.twig', [
            'user' => $user,
            'olymps'=>$olymps
        ]);
    }
}
