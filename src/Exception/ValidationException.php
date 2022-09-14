<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends ApiException
{
    public function __construct(
        private ConstraintViolationListInterface $validationErrors,
        string $message = 'Validation error'
    ) {
        parent::__construct(Response::HTTP_BAD_REQUEST, $message);
    }

    public function jsonSerialize(): array
    {
        $errors = [];

        foreach ($this->validationErrors as $validationError) {
            $errors[] = [
                'propertyPath' => $validationError->getPropertyPath(),
                'message' => $validationError->getMessage()
            ];
        }

        return parent::jsonSerialize() + ['validationErrors' => $errors];
    }
}
