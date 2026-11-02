<?php

// Tandai bahwa aplikasi berjalan di lingkungan Vercel
putenv('VERCEL=1');
$_ENV['VERCEL'] = '1';
$_SERVER['VERCEL'] = '1';

// 1. Buat direktori storage di /tmp karena sistem file Vercel bersifat Read-Only
$storageDirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/storage/app/public',
];

foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// 2. Salin database.sqlite ke /tmp jika belum ada (agar bisa dibaca & ditulis oleh SQLite)
$sourceDb = __DIR__ . '/../database/database.sqlite';
$targetDb = '/tmp/database.sqlite';

if (file_exists($sourceDb) && !file_exists($targetDb)) {
    copy($sourceDb, $targetDb);
}

// 3. Jalankan aplikasi Laravel via public/index.php
require __DIR__ . '/../public/index.php';
