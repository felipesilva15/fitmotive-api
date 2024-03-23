<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class MasterForbiddenHttpException extends HttpException
{
    public function __construct(string $message = 'Você não possui permissão para acessar este registro.', \Throwable $previous = null, int $code = 0, array $headers = []) {
        parent::__construct(403, $message, $previous, $headers, $code);
    }
}