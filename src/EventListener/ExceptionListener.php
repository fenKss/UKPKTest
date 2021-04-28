<?php

namespace App\EventListener;

use App\Controller\Api\TestEditorApiController;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    private TestEditorApiController $apiController;

    public function __construct(TestEditorApiController $apiController)
    {
        $this->apiController = $apiController;
    }
    public function onKernelException(ExceptionEvent $event)
    {
        $request = $event->getRequest();
        if (str_starts_with($request->getPathInfo(), '/api') || $request->getContentType() == 'json'){
             $exception = $event->getThrowable();
             $response = $this->apiController->error($exception->getMessage());
             $event->setResponse($response);
        };
    }
}