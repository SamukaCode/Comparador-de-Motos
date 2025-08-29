<?php
header('Content-Type: application/json; charset=utf-8');

$pdo = require __DIR__ . '/conexao.php';
require_once __DIR__ . '/querys_bd.php';

$marca = $_POST['marca'] ?? '';

if ($marca === '') {
  echo json_encode([]);
  exit;
}

try {
  $modelos = listarModelos($pdo, $marca);
  echo json_encode($modelos);
} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode(['error' => $e->getMessage()]);
}