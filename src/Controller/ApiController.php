<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Exception\ApiException;
use App\DTO\Response;

abstract class ApiController extends AbstractController
{
    public function response(
        mixed $data = null,
        int $status = 200,
        bool $success = true,
        ?ApiException $error = null
    ): JsonResponse {
        $response = new Response($success, $data, $error);
        return parent::json($response, $status);
    }
}
