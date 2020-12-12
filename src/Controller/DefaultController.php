<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(): Response
    {
        return $this->redirectToRoute('admin_index');
//        return $this->render('default/index.html.twig', [
//            'controller_name' => 'DefaultController',
//        ]);
    }

    /**
     * @Route("/admin", name="admin_index")
     */
    public function admin(): Response
    {
        $this->addFlash('error', '123');
        return $this->render('admin/base.html.twig', [
        ]);
    }


}
