<?php
// Bootstrap para tests
require_once __DIR__ . '/../opts.php';
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../execCRUD.php';
require_once __DIR__ . '/../session.php';

// Configurar variables de entorno para testing
$_ENV['DB_HOST'] = 'db';
$_ENV['DB_USER'] = 'root';
$_ENV['DB_PASSWORD'] = 'root';
$_ENV['DB_NAME'] = 'inventory_new';

// Iniciar sesión para tests
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
