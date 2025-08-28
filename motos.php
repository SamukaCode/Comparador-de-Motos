<?php
// motos.php

/**
 * Retorna todas as motos (ajuste o schema se necessário).
 */
function listarMotos(PDO $pdo): array {
    $sql = "SELECT * FROM public.motos ORDER BY id";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

/**
 * Versão com paginação (opcional).
 */
function listarMotosPaginado(PDO $pdo, int $limite = 50, int $offset = 0): array {
    $sql = "SELECT * FROM public.motos ORDER BY id LIMIT :limite OFFSET :offset";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}
