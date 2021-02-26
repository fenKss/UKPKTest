<?php

namespace App\Controller\Admin;

use App\Entity\Olymp;
use App\Entity\Tour;
use App\Entity\UserTest;
use App\Form\TourType;
use App\Repository\OlympRepository;
use App\Repository\UserTestRepository;
use App\Service\PaginationService;
use Carbon\Carbon;
use Doctrine\Common\Persistence\ObjectManager;
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
     * @param OlympRepository   $olympRepository
     * @param PaginationService $pagination
     *
     * @return Response
     */
    public function index(OlympRepository $olympRepository, PaginationService $pagination): Response
    {
        $olympsQuery = $olympRepository->getWithAllQuery();
        $olymps = $pagination->paginate($olympsQuery, 5);
        return $this->render('admin/tour/index.html.twig', [
            'olymps' => $olymps,
            'lastPage' => $pagination->lastPage($olymps)
        ]);
    }

    /**
     * @Route("/new/{olymp}", name="new", methods={"GET","POST"})
     * @param Olymp   $olymp
     * @param Request $request
     *
     * @return Response
     */
    public function new(Olymp $olymp, Request $request): Response
    {
        $tour = new Tour();
        $form = $this->createForm(TourType::class, $tour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($tour->getStartedAt() >= $tour->getExpiredAt()) {
                $this->addFlash('error', 'Тур не может закончиться раньше, чем начался');
                return $this->render('admin/tour/new.html.twig', [
                    'tour' => $tour,
                    'form' => $form->createView(),
                    'olymp' => $olymp
                ]);
            }
            $tour->setOlymp($olymp);
            $index = $olymp->getTours()->count() + 1;
            $tour->setTourIndex($index);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tour);
            $entityManager->flush();

            return $this->redirectToRoute('admin_tour_index');
        }

        return $this->render('admin/tour/new.html.twig', [
            'tour' => $tour,
            'form' => $form->createView(),
            'olymp' => $olymp
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param Tour $tour
     *
     * @return Response
     */
    public function show(Tour $tour): Response
    {
        return $this->render('admin/tour/show.html.twig', [
            'tour' => $tour,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param Request $request
     * @param Tour    $tour
     *
     * @return Response
     */
    public function edit(Request $request, Tour $tour): Response
    {
        $form = $this->createForm(TourType::class, $tour);
        $form->handleRequest($request);

        if ($tour->getPublishedAt()) {
            $this->addFlash('error', 'Тур опубликован. Нужно сначала сделать его неопубликованным');
            return $this->redirectToRoute('admin_tour_index');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            if ($tour->getStartedAt() >= $tour->getExpiredAt()) {
                $this->addFlash('error', 'Тур не может закончиться раньше, чем начался');
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
     * @param Request $request
     * @param Tour    $tour
     *
     * @return Response
     */
    public function delete(Request $request, Tour $tour): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tour->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_tour_index');
    }

    /**
     * @Route("/{id}/publish", name="publish")
     * @IsGranted("ROLE_ADMIN")
     * @param Tour    $tour
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function publish(Tour $tour, Request $request): RedirectResponse
    {
        $page = $request->get('p');
        $olympLanguages = $tour->getOlymp()->getLanguages();
        $tests = $tour->getTests();
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
        if ($olympLanguages->toArray() != $tourLanguages) {
            return $this->addErrorOnPublishAndRedirect(
                'Языки олимпиады не совпадают с языками тестов внутри тура',
                $page);
        }

        $variantsCount = [];
        $optionsCount = [];
        $questionsCount = [];
        foreach ($tests as $test) {
            /*
             * Проверяем количество вариантов в тесте
             */
            $variants = $test->getVariants();
            $variantsCount[$test->getId()] = $variants->count();


            foreach ($variants as $variant) {
                /*
                 * Проверяем количество вопросов в варианте
                 */
                $questions = $variant->getQuestions();
                $questionsCount[$variant->getId()] = $questions->count();


                foreach ($questions as $question) {
                    /*
                     * Проверяем количество ответов в варианте
                     */
                    $options = $question->getPossibleAnswers();
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
     * @param Tour                   $tour
     * @param EntityManagerInterface $em
     * @param UserTestRepository     $userTestRepository
     * @param Request                $request
     *
     * @return RedirectResponse
     */
    public function publishRevert(
        Tour $tour,
        EntityManagerInterface $em,
        UserTestRepository $userTestRepository,
        Request $request
    ): RedirectResponse {
        $page = $request->get('p');
        $userTests = $userTestRepository->getByTour($tour);
        if (count($userTests)) {
            return $this->addErrorOnPublishAndRedirect('На данный тур уже записаны люди', $page);
        }
        $tour->setPublishedAt(null);
        $em->persist($tour);
        $em->flush();

        return $this->addErrorOnPublishAndRedirect(null, $page);
    }

    /**
     * @param string|null $error
     * @param int|null    $page
     *
     * @return RedirectResponse
     */
    private function addErrorOnPublishAndRedirect(?string $error, ?int $page): RedirectResponse
    {
        if ($error) {
            $this->addFlash('error', $error);
        }
        return $this->redirectToRoute("admin_tour_index", [
            'p' => $page
        ]);
    }


}
