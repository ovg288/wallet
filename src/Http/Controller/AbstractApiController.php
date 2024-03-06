<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Http\Reference\ApiResponseTypeKeyEnum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractApiController extends AbstractController
{
    public function success(mixed $result): JsonResponse
    {
        return $this->response([
            ApiResponseTypeKeyEnum::SUCCESS->value => $result
        ], Response::HTTP_OK);
    }

    public function error(
        mixed $result,
        int $statusCode = Response::HTTP_BAD_REQUEST
    ): JsonResponse {
        return $this->response([
            ApiResponseTypeKeyEnum::ERROR->value => $result
        ], $statusCode);
    }

    public function response(array $data, int $status): JsonResponse
    {
        return $this->json($data, $status);
    }
}
