<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\LocalizationMiddleware::class,
        ]);
        
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Throwable $e) {
            http_response_code(500);
            echo "<h1>Original Laravel Exception</h1>";
            echo "<b>Message:</b> " . $e->getMessage() . "<br><br>";
            echo "<b>File:</b> " . $e->getFile() . " on line " . $e->getLine() . "<br><br>";
            echo "<b>Trace:</b><br><pre>" . $e->getTraceAsString() . "</pre>";
            die();
        });
    })->create();

$app->useStoragePath($_ENV['APP_STORAGE'] ?? storage_path());

if (isset($_ENV['APP_STORAGE'])) {
    $app->useBootstrapPath($_ENV['APP_STORAGE'] . '/bootstrap');
}

return $app;
