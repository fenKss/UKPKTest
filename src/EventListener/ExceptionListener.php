<?php

namespace App\EventListener;

use App\Controller\Api\AbstractApiController;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionListener
{
    private AbstractApiController $apiController;

    public function __construct(AbstractApiController $apiController)
    {
        $this->apiController = $apiController;
    }
    public function onKernelException(ExceptionEvent $event)
    {
        $request = $event->getRequest();
        if (str_starts_with($request->getPathInfo(), '/api') || $request->getContentType() == 'json'){
             $exception = $event->getThrowable();
             $response = $this->apiController->error($exception->getMessage());
             if ($exception instanceof NotFoundHttpException){
                 $response->setStatusCode(404);
             }
             $event->setResponse($response);
        }
    }
}