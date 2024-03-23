<?php

namespace App\Exceptions;

use App\Helpers\ApiError;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e) {
        if ($e instanceof HttpException) {
            $data = new ApiError("EXCPHAND001", $e->getMessage(), $request->path());

            return response()->json($data->toArray(), $e->getStatusCode());
        }

        return parent::render($request, $e);
    }
}
