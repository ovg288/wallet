<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Application\UseCase\BalanceChangeUseCaseInterface;
use App\Http\DTO\Input\MakeBalanceChangeInputDto;
use App\Http\DTO\Output\ChangeBalanceOutputDto;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
final class BalanceChangeController extends AbstractApiController
{
    public function __construct(
        private BalanceChangeUseCaseInterface $balanceChangeUseCase,
    ) {
    }

    #[Route('/transaction', methods: ['POST'])]
    public function makeTransaction(
        #[MapRequestPayload] MakeBalanceChangeInputDto $changeBalanceInputDto
    ): JsonResponse {

        try {
            $wallet = $this->balanceChangeUseCase->execute($changeBalanceInputDto);

            return $this->success(
                new ChangeBalanceOutputDto(
                    $wallet->getBalance()->getAmount()->amount(),
                    (string)$wallet->getId(),
                )
            );
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }
}
