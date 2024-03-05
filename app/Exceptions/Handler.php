<?php

namespace App\Exceptions;

use BadMethodCallException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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


        $this->renderable(function (Throwable $e, Request $request) {
            if ($e instanceof NotFoundHttpException) {
                if ($request->is('api/*')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Sayfa Bulunamadı.'
                    ], Response::HTTP_NOT_FOUND);
                }
            }

            if ($e instanceof QueryException) {
                if ($request->is('api/*')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'İşlem Sırasında Sorun Oluştu. Lütfen Bilgileri Kontrol Ederek Tekrar Deneyiniz.'
                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            }

            if ($e instanceof \TypeError) {
                if ($request->is('api/*')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'İstenilen Türden Farklı Bir Veri Türü Gönderiyorsunuz !!!'
                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            }

            if ($e instanceof BadMethodCallException) {
                if ($request->is('api/*')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Tanımlanmamış Yönteme Çağrı !!!'
                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            }

            if ($e instanceof AccessDeniedHttpException) {
                if ($request->is('api/*')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'İşlem Yetkiniz Yok !!!'
                    ], Response::HTTP_FORBIDDEN);
                }
            }
        });
    }
}
