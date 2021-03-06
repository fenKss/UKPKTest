<?php

namespace App\Controller\Admin;

use App\Entity\Olympic;
use App\Entity\Tour;
use App\Entity\UserTest;
use App\Form\TourType;
use App\Repository\OlympicRepository;
use App\Repository\UserTestRepository;
use App\Service\PaginationService;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/tour", name="admin_tour_")
 */
class TourController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(
        OlympicRepository $olympicRepository,
        PaginationService $pagination
    ): Response {
        $olympicsQuery = $olympicRepository->getWithAllQuery();
        $olympics      = $pagination->paginate($olympicsQuery, 5);
        return $this->render('admin/tour/index.html.twig', [
            'olympics' => $olympics,
            'lastPage' => $pagination->lastPage($olympics)
        ]);
    }

    /**
     * @Route("/new/{olympic}", name="new", methods={"GET","POST"})
     */
    public function new(Olympic $olympic, Request $request): Response
    {
        $tour = new Tour();
        $form = $this->createForm(TourType::class, $tour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($tour->getStartedAt() >= $tour->getExpiredAt()) {
                $this->addFlash('error',
                    'Тур не может закончиться раньше, чем начался');
                return $this->render('admin/tour/new.html.twig', [
                    'tour'    => $tour,
                    'form'    => $form->createView(),
                    'olympic' => $olympic
                ]);
            }
            $tour->setOlympic($olympic);
            $index = $olympic->getTours()->count() + 1;
            $tour->setTourIndex($index);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tour);
            $entityManager->flush();

            return $this->redirectToRoute('admin_tour_index');
        }

        return $this->render('admin/tour/new.html.twig', [
            'tour'    => $tour,
            'form'    => $form->createView(),
            'olympic' => $olympic
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Tour $tour): Response
    {
        return $this->render('admin/tour/show.html.twig', [
            'tour' => $tour,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tour $tour): Response
    {
        $form = $this->createForm(TourType::class, $tour);
        $form->handleRequest($request);

        if ($tour->getPublishedAt()) {
            $this->addFlash('error',
                'Тур опубликован. Нужно сначала сделать его неопубликованным');
            return $this->redirectToRoute('admin_tour_index');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            if ($tour->getStartedAt() >= $tour->getExpiredAt()) {
                $this->addFlash('error',
                    'Тур не может закончиться раньше, чем начался');
                return $this->render('admin/tour/edit.html.twig', [
                    'tour' => $tour,
                    'form' => $form->createView(),
                ]);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_tour_index');
        }

        return $this->render('admin/tour/edit.html.twig', [
            'tour' => $tour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Tour $tour): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tour->getId(),
            $request->request->get('_token'))
        ) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_tour_index');
    }

    /**
     * @Route("/{id}/publish", name="publish")
     * @IsGranted("ROLE_ADMIN")
     */
    public function publish(Tour $tour, Request $request): RedirectResponse
    {
        $page             = $request->get('p');
        $olympicLanguages = $tour->getOlympic()->getLanguages();
        $tests            = $tour->getTests();
        if (!$tour->getTests()->count()) {
            return $this->addErrorOnPublishAndRedirect(
                'У тура ни создано не одного теста',
                $page);
        }
        /*
         * Проверяем что бы  языки совпадали в тестах и турах
         */
        $tourLanguages = [];
        foreach ($tests as $test) {
            $tourLanguages[] = $test->getLanguage();
        }
        if ($olympicLanguages->toArray() != $tourLanguages) {
            return $this->addErrorOnPublishAndRedirect(
                'Языки олимпиады не совпадают с языками тестов внутри тура',
                $page);
        }

        $variantsCount  = [];
        $optionsCount   = [];
        $questionsCount = [];
        foreach ($tests as $test) {
            /*
             * Проверяем количество вариантов в тесте
             */
            $variants                      = $test->getVariants();
            $variantsCount[$test->getId()] = $variants->count();


            foreach ($variants as $variant) {
                /*
                 * Проверяем количество вопросов в варианте
                 */
                $questions                         = $variant->getQuestions();
                $questionsCount[$variant->getId()] = $questions->count();


                foreach ($questions as $question) {
                    /*
                     * Проверяем количество ответов в варианте
                     */
                    $options = $question->getOptions();
                    if ($options->count() == 0) {
                        $olympicName  = $test->getTour()->getOlympic()->getName();
                        $languageName = $test->getLanguage()->getName();
                        return $this->addErrorOnPublishAndRedirect(
                            "У одного из вопросов {$variant->getIndex()} варианта {$tour->getTourIndex()} тура '$olympicName' олимпиады нет вариантов ответа. Язык теста: $languageName. id: {$question->getId()}",
                            $page);
                    }
                    $isQuestionCanCorrectOption = false;
                    foreach ($options as $option) {
                        if ($option->getIsCorrect()) {
                            $isQuestionCanCorrectOption = true;
                            break;
                        }
                    }
                    if (!$isQuestionCanCorrectOption) {
                        $olympicName  = $test->getTour()->getOlympic()->getName();
                        $languageName = $test->getLanguage()->getName();
                        return $this->addErrorOnPublishAndRedirect(
                            "У одного из вопросов {$variant->getIndex()} варианта {$tour->getTourIndex()} тура '$olympicName' олимпиады нет правильного варианта ответа. Язык теста: $languageName. id: {$question->getId()}",
                            $page);
                    }
                    if (!isset($optionsCount[$variant->getId()])) {
                        $optionsCount[$variant->getId()] = 0;
                    }
                    $optionsCount[$variant->getId()] += $options->count();
                }
            }
        }

        if (count(array_unique($variantsCount)) != 1) {
            return $this->addErrorOnPublishAndRedirect(
                'Не совпадает количество вариантов на тест',
                $page);
        }
        if (count(array_unique($questionsCount)) != 1) {
            return $this->addErrorOnPublishAndRedirect(
                'Не совпадает количество вопросов на вариант',
                $page);
        }
        if (count(array_unique($optionsCount)) != 1) {
            return $this->addErrorOnPublishAndRedirect(
                'Не совпадает количество ответов на вариант',
                $page);
        }
        $tour->setPublishedAt(new Carbon());
        $em = $this->getDoctrine()->getManager();
        $em->persist($tour);
        $em->flush();

        return $this->addErrorOnPublishAndRedirect(null, $page);
    }

    /**
     * @Route("/{id}/publish/revert", name="publish_revert")
     */
    public function publishRevert(
        Tour $tour,
        EntityManagerInterface $em,
        UserTestRepository $userTestRepository,
        Request $request
    ): RedirectResponse {
        $page      = $request->get('p');
        $userTests = $userTestRepository->getByTour($tour);
        if (count($userTests)) {
            return $this->addErrorOnPublishAndRedirect('На данный тур уже записаны люди',
                $page);
        }
        $tour->setPublishedAt(null);
        $em->persist($tour);
        $em->flush();

        return $this->addErrorOnPublishAndRedirect(null, $page);
    }

    private function addErrorOnPublishAndRedirect(
        ?string $error,
        ?int $page
    ): RedirectResponse {
        if ($error) {
            $this->addFlash('error', $error);
        }
        return $this->redirectToRoute("admin_tour_index", [
            'p' => $page
        ]);
    }

    /**
     * @Route("/{id}/results", name="results")
     */
    public function showResults(Tour $tour, UserTestRepository $testRepository)
    {
        /**
         * @var UserTest[] $userTests
         */
        $correctCount = $tour->getTests()[0]->getVariants()[0]->getCorrectCount();
        $userTests    = $testRepository->getByTour($tour);
        $users        = [];
        $usersAnswers = [];
        foreach ($userTests as $userTest) {
            $answers               = json_decode($userTest->getResultJson(), true)['answers'];
            $count                 = 0;
            $user                  = $userTest->getUser();
            $users[$user->getId()] = $user;
            foreach ($userTest->getVariant()->getQuestions() as $question) {
                $questionAnswers  = $answers[$question->getId()] ?? null;
                $correctOptionsId = $question->getOptions()->filter(function (
                    $option
                ) {
                    return $option->getIsCorrect();
                })->map(function ($option) {
                    return $option->getId();
                })->toArray();

                foreach ($questionAnswers as $questionAnswer) {
                    if ($questionAnswer && in_array($questionAnswer, $correctOptionsId)) {
                        $count++;
                    }
                }
            }
            $usersAnswers[$user->getId()] = $count;
        }
        uasort($usersAnswers, function ($a, $b) {
            if ($a == $b) {
                return 0;
            }
            return ($a > $b) ? -1 : 1;
        });
        $a = [];
        foreach ($usersAnswers as $key=>$answer){
            $a[$answer][] = $users[$key];
        }
        return $this->render('admin/tour/resutls.html.twig', [
            'correctCount' => $correctCount,
            'usersAnswers' => $a,
            'users'        => $users,
            'tour'         => $tour
        ]);
    }
}
