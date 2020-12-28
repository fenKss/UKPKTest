<?php

namespace App\Controller;

use App\Entity\Olymp;
use App\Entity\Tour;
use App\Entity\User;
use App\Entity\UserTest;
use App\ENum\EUserTestStatus;
use App\Form\UserTestForm;
use App\Repository\OlympRepository;
use App\Service\PaginationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
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
     * @param Olymp   $olymp
     * @param Tour    $tour
     * @param Request $request
     *
     * @return Response
     */
    public function signUpToTour(Olymp $olymp, Tour $tour, Request $request): Response
    {
        if (!$this->getUser()) {
            /**
             * @todo Переделать на доступ из security
             */
            return $this->redirectToRoute("app_login");
        }
        $userTest = new UserTest();
        $form = $this->createForm(UserTestForm::class, $userTest, [
            'attr' => [
                'class' => 'form'
            ]
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UserTest $userTest */
            $userTest = $form->getData();
            /** @var User $user */
            $user = $this->getUser();
            $userTest->setUser($user);
            /**
             * @todo Переделать статус оплаты
             */
            $userTest->setStatus(EUserTestStatus::PAID_TYPE);
            $json = [
                'answers' => []
            ];
            $userTest->setResultJson(json_encode($json));

            $chosenTest = null;
            $tests = $tour->getTests();
            foreach ($tests as $test) {
                if ($test->getLanguage() === $userTest->getLanguage()) {
                    $chosenTest = $test;
                    break;
                }
            }
            if (is_null($chosenTest)) {
                return $this->returnSignup($form, $tour,'Не найден тест с выбранным языком');

            }
            $variants = $chosenTest->getVariants();
            if (!$variants->count()) {
                return $this->returnSignup($form, $tour,'Неверное количество вариантов');
            }
            //Выбираем случайно 1 из вариантов
            $i = rand(0, $variants->count() - 1);
            $variant = $variants[$i];
            $userTest->setVariant($variant);
            $em = $this->getDoctrine()->getManager();
            $em->persist($userTest);
            $em->flush();
            return $this->redirectToRoute('user_index');
        }
        return $this->returnSignup($form, $tour);
    }

    private function returnSignup($form, $tour,?string $error = null): Response
    {
        if (!is_null($error)){
            $form->addError(new FormError($error));
        }
        return $this->render('olymp/signup.html.twig', [
            'form' => $form->createView(),
            'tour' => $tour
        ]);
    }
}
