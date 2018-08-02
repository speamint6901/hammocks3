<?php

namespace App\Exceptions;

use Exception;
use Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Validation\ValidationException as FoundationValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exception\HttpResponseException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
        FoundationValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof SaleItemRegisterException) {
            return response()->view('errors.sale_item_register', ["message" => $e->getMessage()], 500);
        }
        if ($e instanceof NotFoundHttpException) {
            return response()->view('errors.404', [], 404);
        }
        if ($e instanceof NotFoundUserException) {
            return response()->view('errors.404', ["message" => $e->getMessage()], 404);
        }
        if ($e instanceof ItemRegisterException) {
            return response()->view('errors.item_register', [], 500);
        }
        if ($e instanceof ApiAuthException) {
            return new JsonResponse(["message" => $e->getMessage()]);
        }
        if ($e instanceof ItemEditException) {
            return new JsonResponse(["message" => $e->getMessage()]);
        }
        if ($e instanceof ArticleContainerException) {
            return new JsonResponse(["message" => $e->getMessage()]);
        }
        if ($e instanceof UserSettingException) {
            return new JsonResponse(["message" => $e->getMessage()]);
        }
        if ($request->ajax()) {
            if ($e instanceof Exception) {
                Log::info($e->getMessage());
                Log::info($e->getTraceAsString());
                return new JsonResponse(["message" => "予期せぬエラーが発生しました"]);
            }
        }
        // HTTPエラー
        if ($e instanceof HttpException) {
            if ($e->getStatusCode() === 404) {
                return response()->view('errors.404', [], 404);
            }
            // メンテナンスモード
            if ($e->getStatusCode() === 503) {
                return response()->view('errors.503', ["message" => $e->getMessage()], 503);
            }
        }
 
        // その他エラー
        if (!($e instanceof ValidationException) && !($e instanceof HttpResponseException) && $e instanceof Exception) {
            Log::info($e->getMessage());
            Log::info($e->getTraceAsString());
            return response()->view('errors.500', ["message" => $e->getMessage()], 500);
        }

        return parent::render($request, $e);
    }
}
