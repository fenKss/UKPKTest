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
     * @param array|null $data
     *
     * @return JsonResponse
     */
    protected function success(?array $data): JsonResponse
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
    protected function error(string $error_msg): JsonResponse
    {
        return $this->json([
            'error' => true,
            'data' => null,
            'error_msg' => $error_msg
        ]);
    }
}