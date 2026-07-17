<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );

        $exceptions->render(function (NotFoundHttpException $e) {

            // Verifica se o erro original foi causado por um registro não encontrado no banco
            if ($e->getPrevious() instanceof ModelNotFoundException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Falha ao buscar Model!',
                ], 404);
            }

            // Retorno padrão para outras rotas inválidas gerais da API
            return response()->json([
                'success' => false,
                'message' => 'Rota não encontrada.',
            ], 404);
        });

    })->create();
