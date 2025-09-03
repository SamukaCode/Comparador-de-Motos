<?php
// conexao.php
$cfg = require __DIR__ . '/secrets.php';

$host     = $cfg['DB_HOST'];
$db       = $cfg['DB_NAME'];
$user     = $cfg['DB_USER'];
$pass     = $cfg['DB_PASS'];

try {
    $dsn = "pgsql:host=$host;port=5432;dbname=$db;sslmode=require;options=project=ep-wispy-darkness-a55dfxbd-pooler";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    return $pdo; // permite: $pdo = require 'conexao.php';
} catch (PDOException $e) {
    http_response_code(500);
    die("Falha na conexão: " . htmlspecialchars($e->getMessage()));
}
