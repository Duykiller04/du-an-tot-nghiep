<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
        $this->renderable(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, $request) {
            if ($e->getStatusCode() == 403) {
                return response()->view('errors.403', [], 403);
            } elseif ($e->getStatusCode() == 404) {
                return response()->view('errors.404', [], 404);
            } elseif ($e->getStatusCode() == 500) {
                return response()->view('errors.500', [], 500);
            }
        });
    }
}

