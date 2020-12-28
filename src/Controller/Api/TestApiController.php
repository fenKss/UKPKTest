<?php


namespace App\Controller\Api;

use App\Entity\UserTest;
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
     */
    public function index(UserTest $test, Request $request)
    {
        if ($this->isCsrfTokenValid('answer'.$test->getId(), $request->request->get('_token'))) {
            $answers = $request->get('answers');
            $answers = @json_decode($answers);
            if (json_last_error() != JSON_ERROR_NONE){
                return $this->error('json error');
            }
            return $this->success($answers);
        }else{
            return $this->error('error');
        }
    }
}