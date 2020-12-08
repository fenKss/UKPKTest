<?php


namespace App\Controller\Admin;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class VariantEditorController
 * @Route("/admin/variant/{variant}", name="admin_variant_editor_")
 *
 * @package App\Controller\Admin
 */
class VariantEditorController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('admin/variant_editor/index.html.twig');
    }
}