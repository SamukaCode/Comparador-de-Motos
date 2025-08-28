<?php
// index.php
$pdo = require __DIR__ . '/conexao.php';
require __DIR__ . '/motos.php';

try {
    $motos = listarMotos($pdo);

    // Se quiser JSON: http://localhost/seuprojeto/index.php?format=json
    if (isset($_GET['format']) && $_GET['format'] === 'json') {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($motos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit;
    }
} catch (Throwable $e) {
    http_response_code(500);
    die("Erro ao listar motos: " . htmlspecialchars($e->getMessage()));
}
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Lista de Motos</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 24px; }
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #ddd; padding: 8px; }
    th { background: #f3f3f3; text-align: left; }
  </style>
</head>
<body>
  <h1>Lista de Motos</h1>
  <p><a href="?format=json">Ver em JSON</a></p>

  <?php if (empty($motos)): ?>
    <p>Nenhum registro encontrado.</p>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <!-- ajuste as colunas conforme sua tabela -->
          <th>ID</th>
          <th>Modelo</th>
          <th>Marca</th>
          <th>Ano</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($motos as $moto): ?>
          <tr>
            <td><?= htmlspecialchars($moto['id'] ?? '') ?></td>
            <td><?= htmlspecialchars($moto['modelo'] ?? '') ?></td>
            <td><?= htmlspecialchars($moto['marca'] ?? '') ?></td>
            <td><?= htmlspecialchars($moto['ano'] ?? '') ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</body>
</html>
