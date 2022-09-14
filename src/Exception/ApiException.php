<?php

declare(strict_types=1);

namespace App\Exception;

use JsonSerializable;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Response;

class ApiException extends HttpException implements JsonSerializable
{
    public function __construct(
        int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR,
        ?string $message = 'Internal Error'
    ) {
        parent::__construct($statusCode, $message);
    }

    public function jsonSerialize(): array
    {
        return [
            'message' => $this->getMessage(),
            'code' => $this->getStatusCode()
        ];
    }
}
