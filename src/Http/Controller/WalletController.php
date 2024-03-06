<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Application\Exception\WalletNotFoundException;
use App\Application\UseCase\GetBalanceUseCase;
use App\Http\DTO\Output\WalletGetBalanceOutputDto;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
final class WalletController extends AbstractApiController
{
    public function __construct(
        private readonly GetBalanceUseCase $getBalanceUseCase,
    ) {
    }

    #[Route('/wallet/{walletId}', methods: ['GET'])]
    public function getWalletBalance(
        int $walletId
    ): JsonResponse {
        try {
            $balance = $this->getBalanceUseCase->execute($walletId);

            return $this->success(
                new WalletGetBalanceOutputDto(
                    $balance->getAmount()->amount(),
                    (string)$balance->getCurrency()
                )
            );
        } catch (WalletNotFoundException $e) {
            return $this->error($e->getMessage());
        }

        // @todo Подумать, как лучше возвращать ответы
        // return $this->success(['result' => 'success']);
    }
}
