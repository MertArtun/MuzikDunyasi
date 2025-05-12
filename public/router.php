<?php

// PHP built-in web server router file for Laravel
// Helps route all requests properly through index.php

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// Serve the file directly if it exists
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false;
}

// Otherwise, include the index.php file
require_once __DIR__ . '/index.php'; 