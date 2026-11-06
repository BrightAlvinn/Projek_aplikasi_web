<?php

// Pastikan direktori sementara tersedia di /tmp untuk lingkungan serverless Vercel (read-only filesystem)
$tmpDirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/bootstrap/cache',
];

foreach ($tmpDirs as $dir) {
    if (! is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Pastikan PHP mengenali koneksi HTTPS dari Vercel
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}

// Forward Laravel requests through Vercel serverless PHP runtime
require __DIR__ . '/../public/index.php';
