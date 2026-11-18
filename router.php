<?php

$root = __DIR__;
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = realpath($root . $path);

if ($file !== false && str_starts_with($file, $root) && is_file($file)) {
    return false;
}

$candidates = [
    $root . $path,
    rtrim($root . $path, '/') . '.php',
    rtrim($root . $path, '/') . '/index.php',
];

foreach ($candidates as $candidate) {
    $resolved = realpath($candidate);
    if ($resolved !== false && str_starts_with($resolved, $root) && is_file($resolved)) {
        require $resolved;
        return;
    }
}

http_response_code(404);
echo 'Not Found';
