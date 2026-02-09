<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

$config = require dirname(__DIR__) . '/config/app.php';

$dsn = sprintf(
    'mysql:host=%s;port=%d;charset=utf8mb4',
    $config['db']['host'],
    $config['db']['port']
);

$pdo = new PDO($dsn, $config['db']['user'], $config['db']['pass'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

$db = $config['db']['name'];

$pdo->exec("CREATE DATABASE IF NOT EXISTS `{$db}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
$pdo->exec("USE `{$db}`");

echo "Running migrations on `{$db}`...\n";

$pdo->exec("
    CREATE TABLE IF NOT EXISTS users (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        two_factor_secret TEXT NULL,
        failed_attempts TINYINT UNSIGNED NOT NULL DEFAULT 0,
        locked_until DATETIME NULL,
        last_login_at DATETIME NULL,
        created_at DATETIME NOT NULL,
        updated_at DATETIME NOT NULL,
        INDEX idx_email (email)
    ) ENGINE=InnoDB
");
echo "  ✓ users\n";

$pdo->exec("
    CREATE TABLE IF NOT EXISTS password_resets (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL,
        token_hash VARCHAR(64) NOT NULL,
        expires_at DATETIME NOT NULL,
        created_at DATETIME NOT NULL,
        INDEX idx_email (email),
        INDEX idx_token (token_hash)
    ) ENGINE=InnoDB
");
echo "  ✓ password_resets\n";

$pdo->exec("
    CREATE TABLE IF NOT EXISTS remember_tokens (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id INT UNSIGNED NOT NULL,
        token_hash VARCHAR(64) NOT NULL,
        expires_at DATETIME NOT NULL,
        created_at DATETIME NOT NULL,
        INDEX idx_user (user_id),
        INDEX idx_token (token_hash),
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB
");
echo "  ✓ remember_tokens\n";

$pdo->exec("
    CREATE TABLE IF NOT EXISTS rate_limits (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        action VARCHAR(50) NOT NULL,
        identifier VARCHAR(100) NOT NULL,
        created_at DATETIME NOT NULL,
        INDEX idx_action_id (action, identifier),
        INDEX idx_created (created_at)
    ) ENGINE=InnoDB
");
echo "  ✓ rate_limits\n";

$pdo->exec("
    CREATE TABLE IF NOT EXISTS audit_logs (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id INT UNSIGNED NULL,
        event VARCHAR(50) NOT NULL,
        ip_address VARCHAR(45) NOT NULL,
        user_agent VARCHAR(500) NULL,
        meta JSON NULL,
        created_at DATETIME NOT NULL,
        INDEX idx_user (user_id),
        INDEX idx_event (event),
        INDEX idx_created (created_at)
    ) ENGINE=InnoDB
");
echo "  ✓ audit_logs\n";

echo "\nAll migrations complete.\n";
