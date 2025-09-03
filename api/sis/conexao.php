<?php
// conexao.php
$cfg = [
  'DB_HOST'     => getenv('DB_HOST') ?: '',
  'DB_NAME'     => getenv('DB_NAME') ?: '',
  'DB_USER'     => getenv('DB_USER') ?: '',
  'DB_PASS'     => getenv('DB_PASS') ?: '',
  'DB_ENDPOINT' => getenv('DB_ENDPOINT') ?: '' // para Neon
];

$host = $cfg['DB_HOST'];
$db   = $cfg['DB_NAME'];
$user = $cfg['DB_USER'];
$pass = $cfg['DB_PASS'];
$endp = $cfg['DB_ENDPOINT'];

try {
    $dsn = "pgsql:host=$host;port=5432;dbname=$db;sslmode=require;options=project=$endp";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    return $pdo; // permite: $pdo = require 'conexao.php';
} catch (PDOException $e) {
    http_response_code(500);
    die("Falha na conexão: " . htmlspecialchars($e->getMessage()));
}
