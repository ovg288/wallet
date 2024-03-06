<?php

declare(strict_types=1);

namespace App\Http\Reference;

enum ApiResponseTypeKeyEnum: string
{
    case SUCCESS = 'success';
    case ERROR = 'error';
}
