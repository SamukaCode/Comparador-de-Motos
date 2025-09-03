<?php

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
