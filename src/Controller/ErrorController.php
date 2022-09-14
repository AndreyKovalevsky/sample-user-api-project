<?php

declare(strict_types=1);

namespace App\Controller;

use Throwable;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Exception\ApiException;

class ErrorController extends ApiController
{
    public function show(Throwable $exception): JsonResponse
    {
        if ($exception instanceof ApiException) {
            return $this->response(
                status: $exception->getStatusCode(),
                success: false,
                error: $exception
            );
        }

        if ($exception instanceof HttpException) {
            return $this->response(
                status: $exception->getStatusCode(),
                success: false,
                error: new ApiException($exception->getStatusCode(), $exception->getMessage())
            );
        }

        return $this->response(
            status: Response::HTTP_INTERNAL_SERVER_ERROR,
            success: false,
            error: new ApiException()
        );
    }
}
