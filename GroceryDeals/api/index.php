<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Spoof the script name so Laravel routing works correctly
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/../public/index.php';

// Ensure /tmp/storage directories exist for Vercel
if (!is_dir('/tmp/storage')) {
    mkdir('/tmp/storage', 0777, true);
    mkdir('/tmp/storage/app/public', 0777, true);
    mkdir('/tmp/storage/bootstrap/cache', 0777, true);
    mkdir('/tmp/storage/framework/cache/data', 0777, true);
    mkdir('/tmp/storage/framework/sessions', 0777, true);
    mkdir('/tmp/storage/framework/views', 0777, true);
    mkdir('/tmp/storage/logs', 0777, true);
}

// Override Laravel's cache paths so they point to the writable /tmp folder
$_SERVER['APP_PACKAGES_CACHE'] = '/tmp/storage/bootstrap/cache/packages.php';
$_SERVER['APP_SERVICES_CACHE'] = '/tmp/storage/bootstrap/cache/services.php';
$_SERVER['APP_CONFIG_CACHE'] = '/tmp/storage/bootstrap/cache/config.php';
$_SERVER['APP_ROUTES_CACHE'] = '/tmp/storage/bootstrap/cache/routes.php';
$_SERVER['APP_EVENTS_CACHE'] = '/tmp/storage/bootstrap/cache/events.php';
$_SERVER['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';

try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    http_response_code(500);
    echo "<h1>Vercel PHP Fatal Error</h1>";
    echo "<b>Message:</b> " . $e->getMessage() . "<br><br>";
    echo "<b>File:</b> " . $e->getFile() . " on line " . $e->getLine() . "<br><br>";
    echo "<b>Trace:</b><br><pre>" . $e->getTraceAsString() . "</pre>";
}
