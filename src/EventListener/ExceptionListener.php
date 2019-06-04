<?php


namespace App\EventListener;


use App\Constant\Messages;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class ExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getException();
        $message = sprintf(
            'Error Occurred: %s with code: %s',
            $exception->getMessage(),
            $exception->getCode()
        );

        // Customize your response object to display the exception details
        $response = new Response();
        $response->setContent($message);
        $data = [
            'status' => 'error',
            'message' => Messages::INTERNAL_SERVER_ERROR,
            'ex' => $exception->getMessage(),
        ];

        $statusCode = 500;
        // HttpExceptionInterface is a special type of exception that
        // holds status code and header details
        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
            switch ($exception) {
                case $exception instanceof MethodNotAllowedHttpException:
                    $statusCode = 400;
                    $data['message'] = Messages::NOT_ALLOWED;
                    break;
                case $exception instanceof NotFoundHttpException:
                    $statusCode = 404;
                    $data['message'] = Messages::NOT_ALLOWED;
                    break;
                case $exception instanceof AccessDeniedHttpException:
                    $statusCode = 401;
                    $data['message'] = $exception->getMessage();
                    break;
            }
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if (strpos($event->getRequest()->getRequestUri(), '/api') !== false) {
            $event->setResponse(new JsonResponse($data, $statusCode));
            return;
        }
        $event->setResponse(new Response($exception->getMessage(), $statusCode));
        // sends the modified response object to the event
    }
}