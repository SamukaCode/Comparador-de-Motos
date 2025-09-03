<?php
// sis/conexao.php
$host    = getenv('DB_HOST') ?: '';
$db      = getenv('DB_NAME') ?: '';
$user    = getenv('DB_USER') ?: '';
$pass    = getenv('DB_PASS') ?: '';
$project = getenv('DB_PROJECT') ?: ''; // opcional (Neon)

if (!$host || !$db || !$user || !$pass) {
  http_response_code(500);
  die('Falha na conexão: variáveis de ambiente ausentes.');
}

$dsn = "pgsql:host={$host};port=5432;dbname={$db};sslmode=require";
// Se quiser usar o parâmetro do Neon, deixe só se corresponder ao SNI:
if ($project) {
  $dsn .= ";options=project={$project}";
}

try {
  $pdo = new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ]);
  return $pdo;
} catch (PDOException $e) {
  http_response_code(500);
  die('Falha na conexão.');
}
