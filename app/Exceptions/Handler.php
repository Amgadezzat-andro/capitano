<?php

namespace App\Exceptions;

use App\Trait\JsonResponsable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    use JsonResponsable;
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

    /**
     * Handle ModelNotFound exception
     */
    public function render($request , Throwable $exception)
    {
        if($exception instanceof ModelNotFoundException)
        {
            $model = $exception->getModel();
            
            if($model === \App\Models\Paneling::class) 
                return $this->failure(404,__("No product found"));
        }
    }
}
