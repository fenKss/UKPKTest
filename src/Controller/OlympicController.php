<?php

namespace App\Controller;

use App\Entity\Tour;
use App\Entity\User;
use App\Entity\UserTest;
use App\ENum\EUserTestStatus;
use App\Form\UserTestForm;
use App\Repository\OlympicRepository;
use App\Service\PaginationService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class OlympicController
 *
 * @Route("/olympic", name="olympic_")
 * @package App\Controller
 */
class OlympicController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(
        OlympicRepository $olympicRepository,
        PaginationService $pagination
    ): Response {
        $queryOlympics = $olympicRepository->getWithPublishedToursQuery();
        $olympics      = $pagination->paginate($queryOlympics, 3);

        return $this->render('olympic/index.html.twig', [
            'olympics' => $olympics,
            'lastPage' => $pagination->lastPage($olympics)
        ]);
    }

    /**
     * @Route("/{olympic}/tour/{tour}/signup/", name="tour_signup")
     * @IsGranted("ROLE_USER")
     */
    public function signUpToTour(
        Tour $tour,
        Request $request
    ): Response {

        $userTest = new UserTest();
        $form     = $this->createForm(UserTestForm::class, $userTest, [
            'tour' => $tour
        ]);
        $form->handleRequest($request);
        if (!($form->isSubmitted() && $form->isValid())) {
            return $this->returnSignup($form, $tour);
        }
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
        $tests      = $tour->getTests();
        foreach ($tests as $test) {
            if ($test->getLanguage() === $userTest->getLanguage()) {
                $chosenTest = $test;
                break;
            }
        }
        if (is_null($chosenTest)) {
            return $this->returnSignup($form, $tour, 'Не найден тест с выбранным языком');
        }
        $userTests = $user->getUserTests();
        foreach ($userTests as $userTest) {
            if ($userTest->getVariant()->getTest()->getTour() === $chosenTest->getTour()) {
                return $this->returnSignup($form, $tour, 'Вы уже записаны на данный тур');
            }
        }

        $variants = $chosenTest->getVariants();
        if (!$variants->count()) {
            return $this->returnSignup($form, $tour, 'Неверное количество вариантов');
        }

        if (!$chosenTest->getTour()->getPublishedAt()) {
            return $this->returnSignup($form, $tour, 'Тур еще не опубликован');
        }

        //Выбираем случайно 1 из вариантов
        $i       = rand(0, $variants->count() - 1);
        $variant = $variants[$i];
        $userTest->setVariant($variant);
        $em = $this->getDoctrine()->getManager();
        $em->persist($userTest);
        $em->flush();
        return $this->redirectToRoute('user_index');

    }

    private function returnSignup($form, $tour, ?string $error = null): Response
    {
        if (!is_null($error)) {
            $form->addError(new FormError($error));
        }
        return $this->render('olympic/signup.html.twig', [
            'form' => $form->createView(),
            'tour' => $tour
        ]);
    }
}
