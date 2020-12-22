<?php

namespace App\Controller;

use App\Entity\Olymp;
use App\Entity\Tour;
use App\Entity\UserTest;
use App\Form\UserTestForm;
use App\Repository\OlympRepository;
use App\Service\PaginationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class OlympController
 *
 * @Route("/olymp", name="olymp_")
 * @package App\Controller
 */
class OlympController extends AbstractController
{
    /**
     * @Route("/", name="index")
     *
     * @param OlympRepository   $olympRepository
     * @param PaginationService $pagination
     *
     * @return Response
     */
    public function index(OlympRepository $olympRepository, PaginationService $pagination): Response
    {
        $queryOlymps = $olympRepository->getWithPublishedToursQuery();
        $olymps = $pagination->paginate($queryOlymps, 3);

        return $this->render('olymp/index.html.twig', [
            'olymps' => $olymps,
            'lastPage' => $pagination->lastPage($olymps),
        ]);
    }

    /**
     * @Route("/{olymp}/tour/{tour}/signup/", name="tour_signup")
     * @param Olymp $olymp
     * @param Tour  $tour
     *
     * @return Response
     */
    public function signUpToTour(Olymp $olymp, Tour $tour): Response
    {
        $userTest = new UserTest();
        $form = $this->createForm(UserTestForm::class, $userTest, [

        ]);

        if ($form->isSubmitted() && $form->isValid()) {
            $userTest = $form->getData();
            dd($userTest);
            return $this->redirectToRoute('user_index');
        }
        return $this->render('olymp/signup.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
