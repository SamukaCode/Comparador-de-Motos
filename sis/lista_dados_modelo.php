<?php
header('Content-Type: application/json; charset=utf-8');

$pdo = require __DIR__ . '/conexao.php';
require_once __DIR__ . '/querys_bd.php';


$marca  = trim($_POST['marca']  ?? '');
$modelo = trim($_POST['modelo'] ?? '');

if ($marca === '' || $modelo === '') {
  echo json_encode([]);
  exit;
}

try {
  $dadosModelo = listarDadosModelo($pdo, $marca, $modelo);
  echo json_encode($dadosModelo);
} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode(['error' => $e->getMessage()]);
}