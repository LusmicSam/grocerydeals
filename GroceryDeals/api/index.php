<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    http_response_code(500);
    echo "<h1>Vercel PHP Fatal Error</h1>";
    echo "<b>Message:</b> " . $e->getMessage() . "<br><br>";
    echo "<b>File:</b> " . $e->getFile() . " on line " . $e->getLine() . "<br><br>";
    echo "<b>Trace:</b><br><pre>" . $e->getTraceAsString() . "</pre>";
}

