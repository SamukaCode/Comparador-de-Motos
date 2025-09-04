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
    $sql = "
        SELECT modelo
        FROM motos
        WHERE marca = :marca
        ORDER BY
          /* 1) Parte textual (sem dígitos), p/ agrupar: 'Ninja ', 'Ninja ZX-R', 'Z', 'Versys '... */
          trim(regexp_replace(lower(modelo), '\d+', ' ', 'g')),

          /* 2) Primeiro número encontrado no nome, como inteiro (se não houver, joga p/ o fim) */
          COALESCE( (substring(modelo from '([0-9]+)'))::int, 2147483647 ),

          /* 3) Desempate estável */
          lower(modelo)
    ";
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
