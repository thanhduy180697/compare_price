<?php

namespace App\Exceptions;

use Exception;
use App\Traits\ApiResponser;
use Asm89\Stack\CorsService;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;


class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $response = $this->handleException($request,$exception);
        app(CorsService::class)->addActualRequestHeaders($response,$request);
        return $response;
    }
    public function handleException($request, Exception $exception){
        // if($exception instanceof ValidationException){
        //     return $this->convertValidationExceptionToResponse($exception,$request);
        // }
        if($exception instanceof ModelNotFoundException){
            $modelName = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse("Does not exits any {$modelName} with the specified identificator",404);
        }
        if($exception instanceof AuthenticationException){
            return $this->errorResponse("Unauthentication. ",401);
        }
        if($exception instanceof AuthorizationException){
            return $this->errorResponse($exception->getMessage(),403);
        }
        if($exception instanceof NotFoundHttpException){
            return $this->errorResponse("The specified URL cannot be found",404);
        }
        if($exception instanceof MethodNotAllowedHttpException){
            return $this->errorResponse("The specified method for the request is invalid",405);
        }
        if($exception instanceof HttpException){
            return $this->errorResponse($exception->getMessage(),$exception->getStatusCode());
        }
        if($exception instanceof QueryException){
            $errorCode = $exception->errorInfo[1];
            if($errorCode == 1451){
                return $this->errorResponse("Cannot remove this resource permanently. It is related with any other resource",409);
            }
            if($errorCode == 1062){
                return $this->errorResponse("Only add one",409);
            }
        }
        if($exception instanceof TokenMismatchException){
            return redirect()->back()->withInput($request->input());
        }
        if(config('app.debug')){
            return parent::render($request, $exception);
        }
        return $this->errorResponse("Unexpected Exception. Try later",500);
    }
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        if ($e->response) {
            return $e->response;
        }
        $errors = $e->validator->errors()->getMessages();
        return $this->errorResponse($errors,422);
    }
}
