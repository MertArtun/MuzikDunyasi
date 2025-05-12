<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
|
| If the application is in maintenance / demo mode via the "down" command
| we will load this file so that any pre-rendered content can be shown
| instead of starting the framework, which could cause an exception.
|
*/

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/

try {
    $app = require_once __DIR__.'/../bootstrap/app.php';

    $kernel = $app->make(Kernel::class);

    // PHP 8.4 Compatibility Fix - Ensure request is properly captured
    try {
        $request = Request::capture();
        $response = $kernel->handle($request)->send();
        $kernel->terminate($request, $response);
    } catch (\Throwable $e) {
        if (PHP_VERSION_ID >= 80400 && strpos($e->getMessage(), 'array offset on null') !== false) {
            echo "<h1>PHP 8.4 Uyumluluk Sorunu</h1>";
            echo "<p>Laravel 10 ve PHP 8.4 arasında bir uyumluluk sorunu oluştu. Lütfen admin ile iletişime geçin.</p>";
            error_log($e->getMessage() . "\n" . $e->getTraceAsString());
            exit(1);
        }
        throw $e;
    }
} catch (\Exception $e) {
    echo "<h1>Uygulama Hatası</h1>";
    echo "<p>Önemli bir hata oluştu. Detaylar için hata günlüğünü kontrol edin.</p>";
    if (env('APP_DEBUG', false)) {
        echo "<h2>Hata Detayları:</h2>";
        echo "<pre>" . $e->getMessage() . "</pre>";
        echo "<h2>Stack Trace:</h2>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    }
    exit(1);
} 