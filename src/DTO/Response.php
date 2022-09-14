<?php

declare(strict_types=1);

namespace App\DTO;

use App\Exception\ApiException;

class Response
{
    public function __construct(
        public bool $success,
        public mixed $data,
        public ?ApiException $error
    ) {
    }
}
