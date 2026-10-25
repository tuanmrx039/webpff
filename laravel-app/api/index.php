<?php

/**
 * Vercel Serverless Entrypoint for Laravel
 */

// Pastikan direktori writeable /tmp tersedia di environment Vercel
$tmpDirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/bootstrap/cache',
];

foreach ($tmpDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

// Copy SQLite database ke /tmp jika menggunakan SQLite default
$dbSource = __DIR__ . '/../database/database.sqlite';
$dbTarget = '/tmp/database.sqlite';
if (file_exists($dbSource) && (!file_exists($dbTarget) || filesize($dbTarget) === 0)) {
    @copy($dbSource, $dbTarget);
}

// Forward request ke standard Laravel public/index.php
require __DIR__ . '/../public/index.php';
