<?php
// conexao.php
$host = 'ep-wispy-darkness-a55dfxbd-pooler.us-east-2.aws.neon.tech';
$db   = 'neondb';
$user = 'neondb_owner';
$pass = 'npg_PxC3ots8mLBj';

try {
    $dsn = "pgsql:host=$host;port=5432;dbname=$db;sslmode=require;options=endpoint=ep-wispy-darkness-a55dfxbd";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    return $pdo; // permite: $pdo = require 'conexao.php';
} catch (PDOException $e) {
    http_response_code(500);
    die("Falha na conexão: " . htmlspecialchars($e->getMessage()));
}
