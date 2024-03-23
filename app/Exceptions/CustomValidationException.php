<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class CustomValidationException extends HttpException
{
    public function __construct(string $message = 'Bad request.', int $statusCode = 400, \Throwable $previous = null, int $code = 0, array $headers = []) {
        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }
}