<?php


namespace App\Controller\Api;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class AbstractApiController
 *
 * @package App\Controller\Api
 */
abstract class AbstractApiController extends AbstractController
{
    /**
     * @param $data
     *
     * @return JsonResponse
     */
    public function success($data): JsonResponse
    {
        return $this->json([
            'error' => false,
            'data' => $data,
            'error_msg' => null
        ]);
    }

    /**
     * @param string $error_msg
     *
     * @return JsonResponse
     */
    public function error(string $error_msg): JsonResponse
    {
        return $this->json([
            'error' => true,
            'data' => null,
            'error_msg' => $error_msg
        ]);
    }
}