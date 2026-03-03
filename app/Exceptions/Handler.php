<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;
use ErrorException;
use InvalidArgumentException;
use BadMethodCallException;

use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
        });
    }


    // public function render($request, Throwable $exception)
    // {
    //     $this->logError($exception);

    //     if ($exception instanceof ValidationException) {
    //         $errorMessage = $exception->getMessage();
    //         return redirect()->back()
    //             ->with([
    //                 'error' => 'Validation error occurred. Please try again.',
    //                 'detailed_error' => $errorMessage
    //             ]);
    //     }

    //     if ($exception instanceof TooManyRequestsHttpException) {
    //         $errorMessage = $exception->getMessage();
    //         return redirect()->back()
    //             ->with([
    //                 'error' => 'Too many requests , view not found. Please try again.',
    //                 'detailed_error' => $errorMessage
    //             ]);
    //     }

    //     if ($exception instanceof ErrorException) {
    //         $errorMessage = $exception->getMessage();
    //         return redirect()->back()
    //             ->with([
    //                 'error' => 'Exception error occurred. Please try again.',
    //                 'detailed_error' => $errorMessage
    //             ]);
    //     }

    //     if ($exception instanceof InvalidArgumentException && str_contains($exception->getMessage(), 'View')) {
    //         return response()->view('error.not_found404', [], 404);
    //     }

    //     if ($exception instanceof InvalidArgumentException) {
    //         $errorMessage = $exception->getMessage();
    //         return redirect()->back()
    //             ->with([
    //                 'error' => 'Invalid argument exception occurred. Please try again.',
    //                 'detailed_error' => $errorMessage
    //             ]);
    //     }

    //     if ($exception instanceof QueryException) {
    //         $errorMessage = $exception->getMessage();
    //         return redirect()->back()
    //             ->with([
    //                 'error' => 'Database error occurred. Please try again.',
    //                 'detailed_error' => $errorMessage
    //             ]);
    //     }

    //     if ($exception instanceof BadMethodCallException) {
    //         $errorMessage = $exception->getMessage();
    //         return redirect()->back()
    //             ->with([
    //                 'error' => 'Bad Method error occurred. Please try again.',
    //                 'detailed_error' => $errorMessage
    //             ]);
    //     }

    //     if ($exception instanceof AuthorizationException) {
    //         $errorMessage = $exception->getMessage();
    //         return redirect()->back()
    //             ->with([
    //                 'error' => 'You are not authorized to perform this action.',
    //                 'detailed_error' => $errorMessage
    //             ]);
    //     }

    //     if ($exception instanceof NotFoundHttpException) {
    //         $errorMessage = $exception->getMessage();
    //         return redirect()->back()
    //             ->with([
    //                 'error' => 'The requested resource could not be found.',
    //                 'detailed_error' => $errorMessage
    //             ]);
    //     }

    //     if ($exception instanceof ModelNotFoundException) {
    //         $errorMessage = $exception->getMessage();
    //         return redirect()->back()
    //             ->with([
    //                 'error' => 'The requested item was not found.',
    //                 'detailed_error' => $errorMessage
    //             ]);
    //     }

    //     if ($exception instanceof AuthenticationException) {
    //         $errorMessage = $exception->getMessage();
    //         return redirect()->back()
    //             ->with([
    //                 'error' => 'You must be logged in to access this page.',
    //                 'detailed_error' => $errorMessage
    //             ]);
    //     }

    //     if ($exception instanceof FileNotFoundException) {
    //         $errorMessage = $exception->getMessage();
    //         return redirect()->back()
    //             ->with([
    //                 'error' => 'The requested file could not be found.',
    //                 'detailed_error' => $errorMessage
    //             ]);
    //     }

    //     if ($exception instanceof BusinessLogicException) {
    //         $errorMessage = $exception->getMessage();
    //         return redirect()->back()
    //             ->with([
    //                 'error' => 'Bussiness error occurred. Please try again.',
    //                 'detailed_error' => $exception->getMessage()
    //             ]);
    //     }

    //     return parent::render($request, $exception);
    // }


    protected function logError(Throwable $exception)
    {
        Log::channel('daily_errors')->error($exception->getMessage(), [
            'exception_type' => get_class($exception), // Type of the exception
            'exception_file' => $exception->getFile(), // File where exception was thrown
            'exception_line' => $exception->getLine(), // Line where exception was thrown
            'environment' => config('app.env'), // Environment (local, production, etc.)
        ]);
    }
}
