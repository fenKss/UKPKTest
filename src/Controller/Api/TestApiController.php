<?php


namespace App\Controller\Api;

use App\Entity\User;
use App\Entity\UserTest;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TestApiController
 * @Route("/api/test/{test}", name="api_test_")
 *
 * @package App\Controller\Api
 */
class TestApiController extends AbstractApiController
{
    /**
     * @Route("/answer", name="_answer")
     * @param UserTest $test
     * @param Request  $request
     *
     * @return JsonResponse
     */
    public function index(UserTest $test, Request $request): JsonResponse
    {
        if (!$this->isCsrfTokenValid('answer' . $test->getId(), $request->request->get('_token'))) {
            return $this->error('auth error');
        }
        /** @var User $user */
        $user = $this->getUser();
        if ($user->getId() != $test->getUser()->getId()){
            return $this->error('auth error');
        }

        $answers = $request->get('answers');
        $answers = @json_decode($answers,true);
        if (json_last_error() != JSON_ERROR_NONE) {
            return $this->error('json error');
        }
        $result = $test->getResultJson();
        $result = @json_decode($result, true);
        if (json_last_error() != JSON_ERROR_NONE) {
            $result = [];
        }
        $result['answers'] = $answers;
        $test->setResultJson(json_encode($result));
        $test->setResultSavedAt(new Carbon());
        $em = $this->getDoctrine()->getManager();
        $em->persist($test);
        $em->flush();
        return $this->success([]);

    }
}