<?php
// motos.php

/**
 * Retorna todas as motos (ajuste o schema se necessário).
 */
function listarMotos(PDO $pdo)
{
    $sql = "SELECT * FROM motos ORDER BY id";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

function listarMarcas(PDO $pdo)
{
    $sql = "SELECT DISTINCT marca FROM motos ORDER BY marca";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

function listarModelos(PDO $pdo, $marca)
{
    $sql = "SELECT modelo 
            FROM motos 
            WHERE marca = :marca 
            ORDER BY modelo";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':marca', $marca, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll();
}

function listarDadosModelo(PDO $pdo, $marca, $modelo)
{
    $sql = "SELECT * 
            FROM motos 
            WHERE marca = :marca AND modelo = :modelo";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':marca',  $marca,  PDO::PARAM_STR);
    $stmt->bindValue(':modelo', $modelo, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll();
}


/**
 * Versão com paginação (opcional).
 */
function listarMotosPaginado(PDO $pdo, int $limite = 50, int $offset = 0): array
{
    $sql = "SELECT * FROM public.motos ORDER BY id LIMIT :limite OFFSET :offset";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}
