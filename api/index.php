<?php
// index.php
$pdo = require __DIR__ . '/sis/conexao.php';
require __DIR__ . '/sis/querys_bd.php';

$marcas = listarMarcas($pdo);

?>
<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <title>Duas Rodas - Comparador de Motos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous">

    <link rel="stylesheet" href="assets/css/site.css?v=<?= filemtime(__DIR__.'/assets/css/site.css') ?>">
<style>
      :root {
      --brand-red: #E53935;
      --brand-red-d: #B71C1C;
      --brand-black: #111111;
      --brand-cream: #F5E6DA;
    }

    html,
    body {
      height: 100%;
    }

    body {
      margin: 0;
      background: var(--brand-cream);
      color: var(--brand-black);
    }

    /* HEADER (logo no topo) */
    .site-header {
      background: linear-gradient(180deg, var(--brand-red) 0%, var(--brand-red-d) 100%);
      padding: clamp(8px, 1.5vw, 16px) clamp(16px, 4vw, 32px);
      /* Adicionando padding horizontal */
      box-shadow: 0 6px 16px rgba(0, 0, 0, .12);
    }

    .site-brand {
      /* max-width: 1200px;   <- remova */
      /* margin: 0 auto;      <- remova */
      width: 100%;
      /* ocupa toda a largura do header */
      margin: 0;
      /* encosta à esquerda */
      display: flex;
      align-items: center;
      gap: 20px;
      justify-content: flex-start;
      /* garante alinhamento à esquerda */
    }

    /* bloco de textos do logo: força alinhamento à esquerda */
    .brand-wrap {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      text-align: left;
    }

    .site-brand img {
      height: clamp(56px, 8vw, 96px);
      /* Ajusta a altura da imagem de forma responsiva */
      width: auto;
      /* Remova a borda e o border-radius para se adaptar à nova imagem PNG */
      border-radius: 4px;
      filter: none;
      /* Remova a sombra, se a nova imagem já tiver uma ou não precisar */
    }

    .brand-title {
      color: #fff;
      margin: 0;
      font-weight: 800;
      letter-spacing: .5px;
    }

    .brand-sub {
      color: rgba(255, 255, 255, .7);
      /* Opacidade reduzida */
      margin: 0;
      font-size: 20px;
      /* Fonte um pouco menor */
      line-height: 1.2;
    }

    /* Se quiser o header fixo no topo, descomente: */
    /* .site-header{ position: sticky; top: 0; z-index: 1030; } */

    /* A seção principal agora é só um container (sem 30/70) */
    .split-hero {
      display: block;
      min-height: auto;
    }


    .container-conteudo {
      background: var(--brand-cream);
      padding: clamp(16px, 4vw, 48px);
      overflow: auto;
    }

    /* cartão branco que envolve a área de seleção */
    .container-selecao {
      background: #fff;
      padding: 20px;
      border-radius: 14px;
      box-shadow: 0 8px 22px rgba(0, 0, 0, .06);
    }

    /* título de cada seleção com ícone */
    .compare-divider {
      width: 4px;
      background: var(--brand-red);
      border-radius: 4px;
      align-self: stretch;
    }

    /* cabeçalho de cada coluna */
    .compare-head {
      display: flex;
      align-items: center;
      gap: 10px;
      font-weight: 600;
      margin-bottom: 10px;
    }

    .moto-icon {
      width: 32px;
      height: 32px;
      object-fit: contain;
    }

    /* linha do botão: gruda no fim do card */
    .container-button {
      display: flex;
      justify-content: flex-end;
      gap: 12px;
      margin-top: 16px;
    }

    /* Botão Comparar – usando os tons da marca */
    .btn-comparar {
      background-color: transparent;
      color: var(--brand-red);
      /* texto/ícone herdam esta cor */
      width: 8.5em;
      height: 2.9em;
      border: 0.2em solid var(--brand-red);
      border-radius: 11px;
      display: inline-flex;
      /* alinha texto e ícone */
      align-items: center;
      justify-content: center;
      gap: .6em;
      padding: 0 1em;
      position: relative;
      transition: all .6s ease;
    }

    .btn-comparar:hover {
      background-color: var(--brand-red);
      /* fill vermelho no hover */
      color: #fff;
      border-color: var(--brand-red-d);
      cursor: pointer;
      box-shadow: 0 6px 16px rgba(183, 28, 28, .25);
    }

    .btn-comparar:active {
      transform: translateY(1px);
    }

    /* Acessibilidade no foco */
    .btn-comparar:focus-visible {
      outline: 3px solid rgba(229, 57, 53, .35);
      outline-offset: 2px;
    }

    /* Ícone segue a cor do texto (currentColor) e anima no hover */
    .btn-comparar svg {
      width: 1.4em;
      /* ajuste do tamanho do ícone */
      height: 1.4em;
      margin: 0;
      /* remove margens quebradas */
      transition: transform .6s ease;
    }

    .btn-comparar:hover svg {
      transform: translateX(6px);
    }

    /* texto */
    .btn-comparar .text {
      margin: 0;
    }

    @media (min-width: 768px) {
      .moto-icon {
        width: 36px;
        height: 36px;
      }
    }

    /* grade das duas seleções + divisor */
    .compare-wrap {
      display: flex;
      gap: 24px;
      align-items: flex-start;
    }

    .compare-col {
      flex: 1 1 0;
      min-width: 0;
    }

    /* divisor vermelho entre as seleções */
    .compare-divider {
      width: 4px;
      background: var(--brand-red);
      border-radius: 4px;
      align-self: stretch;
    }

    /* mobile: empilha e transforma o divisor em barra horizontal */
    @media (max-width: 767.98px) {
      .compare-wrap {
        flex-direction: column;
      }

      .compare-divider {
        width: 100%;
        height: 3px;
        border-radius: 3px;
      }
    }

    /* desktop 30/70 (conteúdo 70%, imagem 30%) */
    @media (min-width: 992px) {
      .split-hero {
        grid-template-columns: 7fr 3fr;
      }

      .container-logo {
        min-height: 100vh;
      }
    }

    /* Botões e foco */
    .btn-primary{
  --bs-btn-color: #fff;
  --bs-btn-bg: var(--brand-red);
  --bs-btn-border-color: var(--brand-red);

  --bs-btn-hover-color: #fff;
  --bs-btn-hover-bg: var(--brand-red-d);
  --bs-btn-hover-border-color: var(--brand-red-d);

  /* <- estes dois resolvem o azul ao “segurar” */
  --bs-btn-active-color: #fff;
  --bs-btn-active-bg: var(--brand-red-d);
  --bs-btn-active-border-color: var(--brand-red-d);

  /* opcional: manter consistência em disabled */
  --bs-btn-disabled-bg: var(--brand-red);
  --bs-btn-disabled-border-color: var(--brand-red);

  /* cor do anel de foco */
  --bs-btn-focus-shadow-rgb: 229,57,53;
}


    .form-select:focus,
    .form-control:focus {
      border-color: var(--brand-red);
      box-shadow: 0 0 0 .25rem rgba(229, 57, 53, .25);
    }

    /* --- TABELA CUSTOM (atributo no meio + valores abaixo) --- */
/* wrapper é quem arredonda e recorta */
.table-compare-wrap{
  border-radius: 12px;
  overflow: hidden;                 /* recorta o thead sticky nas bordas */
}

/* tabela normal */
.table-compare{
  border-collapse: separate;
  border-spacing: 0;
  width: 100%;
  background: transparent;          /* usa o fundo do wrapper */
}

/* cabeçalho sticky continua igual */
.table-compare thead th{
  position: sticky;
  position: -webkit-sticky;
  top: var(--thead-offset, 0px);    /* se usar header fixo, ajuste essa var */
  z-index: 2;
  background: var(--brand-red-d);
  color: #fff;
  padding: 1.25rem 1rem;
  box-shadow: 0 4px 8px rgba(0,0,0,.1);
  background-clip: padding-box;     /* evita “vazar” na borda */
}

/* opcional: arredondar visual do topo do thead também */
.table-compare thead th:first-child{ border-top-left-radius: 14px; }
.table-compare thead th:last-child { border-top-right-radius: 14px; }


    .table-compare.custom td,
    .table-compare.custom th {
      vertical-align: middle;
    }

    /* linha do rótulo (meio) */
    .table-compare .label-row td {
      border: 0;
      padding: 10px;
    }

    .table-compare .attr-name {
      text-align: center;
    }

    .table-compare .attr-chip {
      display: inline-block;
      background: var(--brand-red);
      color: #fff;
      font-weight: 700;
      /* Use um peso de fonte mais alto para destaque */
      font-size: 1rem;
      padding: 0.5rem 1rem;
      /* Aumenta um pouco o padding para mais espaço */
      border-radius: 999px;
      text-transform: uppercase;
      /* Deixa o texto em caixa alta */
      letter-spacing: 0.5px;
      /* Adiciona um pequeno espaçamento entre as letras */
    }

    /* linha dos valores (abaixo) */
    .table-compare .values-row td {
      border-top: 1px solid rgba(0, 0, 0, .06);
      padding: 12px 10px;
    }

    .table-compare .values-row td:first-child,
    .table-compare .values-row td:last-child {
      font-weight: 600;
    }

    /* colunas */
    .table-compare .col-left,
    .table-compare .col-right {
      width: 38%;
    }

    .table-compare .col-mid {
      width: 24%;
    }

    /* zebra suave por bloco (a cada atributo) */
    .table-compare .block-even .values-row td {
      background: rgba(0, 0, 0, .035);
    }

    /* Centraliza a tabela e controla largura responsiva */
    .table-compare.custom {
      /* Centraliza horizontalmente e define a largura */
      margin: 0 auto;
      width: clamp(320px, 90vw, 960px);
      /* Estilização */
      border-collapse: separate;
      border-spacing: 0;
      border-radius: 12px;
      /* Cantos arredondados */
      overflow: hidden;
      /* Garante que os cantos arredondados funcionem */
      box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
      /* Sombra suave */
    }

    /* Centralização horizontal + largura responsiva */
    .table-compare.custom {
      margin: 0 auto;
      /* centraliza o <table> */
      width: clamp(320px, 90vw, 960px);
      /* fluido até 960px */
      table-layout: fixed;
      /* colunas com mesma largura */
    }

    .container-conteudo { overflow: visible; }     /* estava auto */
.table-compare-wrap { overflow: visible; }     /* se tiver max-height, remova */
.table-compare.custom { overflow: visible; }


    /* Centraliza texto de cabeçalhos e células */
    .table-compare.custom th,
    .table-compare.custom td {
      text-align: center;
    }

    /* chip centralizado de verdade (sem largura fixa) */
    .table-compare .attr-name {
      text-align: center;
    }

    .table-compare .attr-chip {
      width: auto;
      /* <- remova o width:25% anterior */
      margin-inline: auto;
      /* centraliza o chip */
      display: inline-block;
    }

    /* opcional: deixa os valores bem centralizados e com separação suave */
    .table-compare .values-row td {
      padding: 1rem 1.25rem;
      /* Aumenta o padding para mais respiro */
      font-size: 1rem;
      line-height: 1.4;
      vertical-align: top;
      /* Alinha o texto no topo se o conteúdo for grande */
    }

    /* Bordas suaves entre as células */
    .table-compare td {
      border-bottom: 1px solid rgba(0, 0, 0, .05);
    }

    /* Bordas entre as colunas */
    .table-compare .values-row td+td {
      border-left: 1px dashed rgba(0, 0, 0, .1);
      /* Borda tracejada entre as colunas */
    }

    /* Remove a borda inferior da última linha (opcional) */
#tComparar tbody tr:last-of-type > td {
  border-bottom: 0;
}

/* Primeiro td da última tr: canto inferior esquerdo */
#tComparar tbody tr:last-of-type > td:first-of-type {
  border-radius: 0 0 0 12px; /* top-left 0, top-right 0, bottom-right 0, bottom-left 12px */
}

/* Segundo td da última tr: canto inferior direito */
#tComparar tbody tr:last-of-type > td:last-of-type {
  border-radius: 0 0 12px 0; /* top-left 0, top-right 0, bottom-right 12px, bottom-left 0 */
}


    /* ícones sociais no canto direito do header */
    .social-stack {
      margin-left: auto;
      /* empurra para a direita */
      display: flex;
      flex-direction: row;
      /* vertical */
      gap: 20px;
      align-items: flex-end;
      /* alinha à direita */
    }

    .social-link {
      color: var(--brand-cream);
      /* cor dos ícones */
      opacity: .9;
      transition: opacity .2s, transform .2s;
      line-height: 0;
      /* tira respiro extra */
    }

    .social-link:hover {
      opacity: 1;
      transform: translateY(-1px);
    }

    .social-link svg {
      width: 48px;
      height: 48px;
      display: block;
    }

    @media (max-width: 420px) {
      .social-stack {
        flex-direction: row;
        align-items: center;
      }
    }




    /* responsivo: em telas pequenas, diminui um pouco a pílula */
    @media (max-width: 991.98px) {
      .table-compare .attr-chip {
        font-size: .85rem;
        padding: .4rem .7rem;
      }
    }


    /* === LOADER usando assets/icons/moto.svg === */
    .moto-loader {
      display: none;
      /* aparece com .show */
      justify-content: center;
      align-items: center;
      flex-direction: column;
      gap: 10px;
      padding: 24px 0;
    }

    .moto-loader.show {
      display: flex;
    }

    .moto-loader .loader-text {
      color: var(--brand-black);
      opacity: .75;
      font-weight: 600;
      font-size: .95rem;
    }

    .moto-silhouette {
      width: 100%;
      height: auto;
      display: block;
      animation: moto-bob 1.2s ease-in-out infinite;
      filter: drop-shadow(0 4px 10px rgba(0, 0, 0, .15));
    }

    /* --- calibração fina do loader (usa variáveis) --- */
    .moto-anim {
      position: relative;
      width: clamp(170px, 26vw, 240px);

      /* POSIÇÕES DOS CENTROS DAS RODAS (em %) + TAMANHO DO ANEL */
      /* valores ajustados para o seu assets/icons/moto.svg do print */
      --wlx: 30%;
      /* X roda ESQ  (antes 28%) */
      --wly: 66%;
      /* Y roda ESQ  (antes 72%) */
      --wrx: 83%;
      /* X roda DIR  (antes 82%) */
      --wry: 66%;
      /* Y roda DIR  (antes 72%) */
      --ring: clamp(52px, 7.5vw, 68px);
      /* diâmetro do anel */
    }

    .wheel-ring {
      position: absolute;
      width: var(--ring);
      height: var(--ring);
      border: 4px solid var(--brand-red-d);
      border-top-color: transparent;
      border-radius: 50%;
      animation: moto-spin .8s linear infinite;
      opacity: .95;
    }

    .wheel-left {
      left: var(--wlx);
      top: var(--wly);
      transform: translate(-50%, -50%);
    }

    .wheel-right {
      left: var(--wrx);
      top: var(--wry);
      transform: translate(-50%, -50%);
    }

    /* mantém as animações */



    /* fumacinha */
    .puff {
      position: absolute;
      left: 12%;
      top: 60%;
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background: var(--brand-red);
      opacity: 0;
      animation: moto-puff 1.8s ease-out infinite;
    }

    .puff.d1 {
      animation-delay: .25s
    }

    .puff.d2 {
      animation-delay: .5s
    }

    /* animações */
    @keyframes moto-spin {
      to {
        transform: translate(-50%, -50%) rotate(360deg);
      }
    }

    @keyframes moto-bob {

      0%,
      100% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-2px);
      }
    }

    @keyframes moto-puff {
      0% {
        transform: translateX(0) scale(.6);
        opacity: 0;
      }

      30% {
        opacity: .75;
      }

      100% {
        transform: translateX(-28px) scale(1.2);
        opacity: 0;
      }
    }

    /* Layout p/ footer grudar na parte inferior */
    body {
      min-height: 100dvh;
      /* cobre viewport inteira */
      display: flex;
      flex-direction: column;
    }

    .split-hero {
      /* sua área principal */
      flex: 1 0 auto;
      /* empurra o footer para baixo */
    }

    /* Footer simples + mesma cor do header */
    .site-footer {
      margin-top: auto;
      /* gruda no fim da página */
      background: linear-gradient(180deg, var(--brand-red) 0%, var(--brand-red-d) 100%);
      color: var(--brand-cream);
    }

    .site-footer .footer-inner {
      max-width: 1200px;
      margin: 0 auto;
      padding: 12px clamp(16px, 4vw, 32px);
      text-align: center;
      font-size: .95rem;
      opacity: .95;
    }

    .site-footer a {
      color: var(--brand-cream);
      text-decoration: none;
    }

    .site-footer a:hover {
      text-decoration: underline;
    }

    /* --- Tabela responsiva (stack) para telas pequenas --- */
@media (max-width: 576px){
  /* some o thead no mobile (vamos mostrar o nome do modelo via ::before) */
.table-compare.custom thead th {
        padding: 10px;
    font-size: 15px;
}

    .table-compare .attr-chip {
        font-size: 14px;
        padding: .4rem .7rem;
    }

  .btn-comparar {
    width: 100%;
}

    .site-brand img {
      height: 52px;
    }

    .brand-title {
      font-size: 20px;
    }

    .brand-sub {
      font-size: 14px;
    }

    
    .social-link svg {
      width: 32px;
      height: 32px;
    }

    .compare-head {
    justify-content: center;
}
}

</style>

</head>

<body>
  <header class="site-header">
    <div class="site-brand">
      <img src="/assets/logo.png" alt="Duas Rodas — Comparador de Motos">
      <div class="brand-wrap">
        <h1 class="brand-title">Duas Rodas</h1>
        <p class="brand-sub">Comparador de motos</p>
      </div>

      <!-- Ícones sociais (direita) -->
      <div class="social-stack">
        <a class="social-link"
          href="https://www.linkedin.com/in/samuel--camargo"
          target="_blank" rel="noopener"
          aria-label="LinkedIn de Samuel Camargo">
          <!-- LinkedIn -->
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" fill="currentColor" role="img" aria-hidden="true">
            <path d="M41,4H9C6.24,4,4,6.24,4,9v32c0,2.76,2.24,5,5,5h32c2.76,0,5-2.24,5-5V9C46,6.24,43.76,4,41,4z M17,20v19h-6V20H17z
                   M11,14.47c0-1.4,1.2-2.47,3-2.47s3,1.07,3,2.47c0,1.4-1.12,2.53-3,2.53S11,15.87,11,14.47z M39,39h-6c0,0,0-9.26,0-10
                   c0-2-1-4-3.5-4.04h-0.08C26,24.96,25,27.02,25,29c0,0.91,0,10,0,10h-6V20h6v2.56c0,0,1.93-2.56,5.81-2.56
                   C36.78,20,40,22.73,40,28.26V39z" />
          </svg>
        </a>

        <a class="social-link"
          href="https://github.com/SamukaCode"
          target="_blank" rel="noopener"
          aria-label="GitHub de Samuel Camargo">
          <!-- GitHub -->
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" fill="currentColor" role="img" aria-hidden="true">
            <path d="M25 2C12.85 2 3 11.85 3 24c0 9.71 6.29 17.93 15.02 20.84c.77.14 1.05-.33 1.05-.74
                   c0-.36-.01-1.31-.02-2.57c-6.11 1.33-7.4-2.94-7.4-2.94c-.7-1.78-1.71-2.25-1.71-2.25c-1.4-.96.11-.94.11-.94
                   c1.55.11 2.36 1.6 2.36 1.6c1.38 2.36 3.63 1.68 4.51 1.28c.14-1 .54-1.68.98-2.07c-4.88-.56-10.01-2.44-10.01-10.86
                   c0-2.4.86-4.36 2.28-5.9c-.23-.56-.99-2.83.22-5.9c0 0 1.86-.6 6.1 2.25c1.77-.49 3.67-.74 5.57-.75c1.89.01 3.8.26 5.57.75
                   c4.24-2.85 6.1-2.25 6.1-2.25c1.21 3.07.45 5.34.22 5.9c1.42 1.54 2.28 3.5 2.28 5.9c0 8.44-5.14 10.29-10.03 10.85
                   c.56.49 1.05 1.46 1.05 2.95c0 2.13-.02 3.85-.02 4.38c0 .41.28.89 1.06.74C40.72 41.93 47 33.71 47 24
                   C47 11.85 37.15 2 25 2z" />
          </svg>
        </a>
      </div>
    </div>
  </header>


  <!-- SUBSTITUA O HEADER + CONTAINERS INICIAIS POR ESTE BLOCO -->
  <section class="split-hero">


    <!-- METADE 2: CONTEÚDO -->
    <div class="container-conteudo">
      <div class="container-fluid p-0">
        <div class="container-selecao">
          <div class="compare-wrap">
            <!-- COLUNA 1 -->
            <div class="compare-col">
              <div class="compare-head">
                <img class="moto-icon" src="/assets/icons/moto.svg" alt="">
                <span>Moto 1</span>
              </div>

              <div class="row g-3 align-items-end mb-3">
                <div class="col-sm-6 col-md-8 col-lg-6">
                  <label for="selMarca-01" class="form-label">Marca</label>
                  <select id="selMarca-01" class="form-select">
                    <option value="">Selecione...</option>
                    <?php foreach ($marcas as $m): ?>
                      <option value="<?= htmlspecialchars($m['marca'], ENT_QUOTES) ?>">
                        <?= htmlspecialchars($m['marca']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-sm-6 col-md-8 col-lg-6">
                  <label for="selModelo-01" class="form-label">Modelo</label>
                  <select id="selModelo-01" class="form-select" disabled>
                    <option value="">Selecione a marca primeiro</option>
                  </select>
                </div>
              </div>
            </div>

            <!-- DIVISOR VERMELHO -->
            <div class="compare-divider" aria-hidden="true"></div>

            <!-- COLUNA 2 -->
            <div class="compare-col">
              <div class="compare-head">
                <img class="moto-icon" src="/assets/icons/moto.svg" alt="">
                <span>Moto 2</span>
              </div>

              <div class="row g-3 align-items-end mb-3">
                <div class="col-sm-6 col-md-8 col-lg-6">
                  <label for="selMarca-02" class="form-label">Marca</label>
                  <select id="selMarca-02" class="form-select">
                    <option value="">Selecione...</option>
                    <?php foreach ($marcas as $m): ?>
                      <option value="<?= htmlspecialchars($m['marca'], ENT_QUOTES) ?>">
                        <?= htmlspecialchars($m['marca']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-sm-6 col-md-8 col-lg-6">
                  <label for="selModelo-02" class="form-label">Modelo</label>
                  <select id="selModelo-02" class="form-select" disabled>
                    <option value="">Selecione a marca primeiro</option>
                  </select>
                </div>
              </div>
            </div>


          </div><!-- /compare-wrap -->
          <div class="container-button">
            <button class="btn-comparar" id="btnComparar">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"></path>
              </svg>
              <div class="text">
                Comparar
              </div>
            </button>
          </div>
        </div><!-- /container-selecao -->



        <div id="boxComparar" class="mt-4 d-none">
          <div id="loaderComparar" class="moto-loader" aria-live="polite" aria-busy="true">
            <div class="moto-anim" aria-hidden="true">
              <!-- usa seu SVG da pasta -->
              <img src="/assets/icons/moto.svg" alt="" class="moto-silhouette">
              <span class="puff"></span><span class="puff d1"></span><span class="puff d2"></span>
            </div>
            <div class="loader-text">Acelerando os dados…</div>
          </div>

          <!-- DESKTOP: Tabela -->
<div class="table-compare-wrap">
  <table id="tComparar" class="table table-compare align-middle">
              <thead>
                <tr>
                  <th id="thModel1">Modelo A</th>
                  <th id="thModel2">Modelo B</th>
                </tr>
              </thead>
              <tbody><!-- preenchido via JS --></tbody>
            </table>
          </div>
        </div>


      </div>
    </div>


  </section>

  <footer class="site-footer" role="contentinfo">
    <div class="footer-inner">
      © <?= date('Y') ?> Duas Rodas — Comparador de Motos. Todos os direitos reservados.<br>
      Desenvolvido por <a href="https://www.linkedin.com/in/samuel--camargo" target="_blank" rel="noopener">Samuel Camargo</a>.
    </div>
  </footer>



  <!-- jQuery 3 -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"></script>

  <!-- Bootstrap 5 JS (bundle inclui Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

  <script>
    // helpers
    function escapeHtml(s) {
      return String(s ?? '').replace(/[&<>"']/g, m => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
      } [m]));
    }
    const fmtNum = new Intl.NumberFormat('pt-BR', {
      maximumFractionDigits: 2
    });
    const fmtBRL = new Intl.NumberFormat('pt-BR', {
      style: 'currency',
      currency: 'BRL'
    });

    // mesmo mapa de atributos que você usa em renderTabelaModelo
    const MAPA_ATRIBUTOS = [
      ['cilindrada', 'Cilindrada'],
      ['potencia', 'Potência'],
      ['torque', 'Torque'],
      ['transmissao', 'Transmissão'],
      ['suspensao_dianteira', 'Suspensão dianteira'],
      ['suspensao_traseira', 'Suspensão traseira'],
      ['freios', 'Freios'],
      ['pneus', 'Pneus'],
      ['peso', 'Peso'],
      ['altura_do_assento', 'Altura do assento'],
      ['tanque', 'Tanque'],
      ['consumo_medio', 'Consumo médio']
    ];

    function formatar(chave, val) {
      if (val === null || typeof val === 'undefined' || val === '') return '-';
      if (chave === 'preco' && !isNaN(Number(val))) return fmtBRL.format(Number(val));
      if (['peso', 'altura_do_assento', 'tanque', 'consumo_medio'].includes(chave) && !isNaN(Number(val))) return fmtNum.format(Number(val));
      return String(val);
    }

    function showLoader() {
      $('#boxComparar').removeClass('d-none');
      $('#loaderComparar').addClass('show');
      $('#btnComparar').prop('disabled', true);
      $('#tComparar thead, #tComparar tbody').empty();
      $('#accComparar').empty();
    }

    function hideLoader() {
      $('#loaderComparar').removeClass('show');
      $('#btnComparar').prop('disabled', false);
    }


    // Seções para o accordion (agrupam atributos)
    const SECOES = [{
        titulo: 'Motor / Transmissão',
        itens: [
          ['cilindrada', 'Cilindrada'],
          ['potencia', 'Potência'],
          ['torque', 'Torque'],
          ['transmissao', 'Transmissão']
        ]
      },
      {
        titulo: 'Suspensão & Freios',
        itens: [
          ['suspensao_dianteira', 'Suspensão dianteira'],
          ['suspensao_traseira', 'Suspensão traseira'],
          ['freios', 'Freios'],
          ['pneus', 'Pneus']
        ]
      },
      {
        titulo: 'Dimensões',
        itens: [
          ['peso', 'Peso'],
          ['altura_do_assento', 'Altura do assento'],
          ['tanque', 'Tanque']
        ]
      },
      {
        titulo: 'Economia & Preço',
        itens: [
          ['consumo_medio', 'Consumo médio'],
          ['preco', 'Preço']
        ]
      },
    ];

    // unidades por atributo (ajuste como preferir)
const UNIDADES = {
  consumo_medio: ' km/l',
  tanque:        ' L',
  peso:          ' kg',
  altura_do_assento: ' mm',
};

// só adiciona unidade se o valor for “puro número” (evita duplicar)
function formatarComUnidade(chave, val){
  const base = formatar(chave, val);
  if (base === '-') return base;

  const unidade = UNIDADES[chave];
  if (!unidade) return base;

  // se o valor original já tem letras/símbolos (ex.: "25 km/l"), não acrescenta
  const temUnidadeNoOriginal = /[^0-9.,\-]/.test(String(val ?? '').trim());
  return temUnidadeNoOriginal ? base : (base + unidade);
}



    function renderTabelaComparativo(a, b) {
      const $table = $('#tComparar').addClass('custom');
      const $thead = $table.find('thead').empty();
      const $tbody = $table.find('tbody').empty();

      // Cabeçalho: nomes dos modelos
      const nomeA = (a?.marca && a?.modelo) ? `${a.marca} ${a.modelo}` : 'Modelo A';
      const nomeB = (b?.marca && b?.modelo) ? `${b.marca} ${b.modelo}` : 'Modelo B';
      $thead.append(`
    <tr>
      <th id="thModel1">${escapeHtml(nomeA)}</th>
      <th id="thModel2">${escapeHtml(nomeB)}</th>
    </tr>
  `);

      // Para cada atributo: 1) linha-título (colspan=2), 2) linha com valores (duas colunas)
      MAPA_ATRIBUTOS.forEach(([key, rotulo], idx) => {
        const va = formatarComUnidade(key, a?.[key]);
const vb = formatarComUnidade(key, b?.[key]);


        // linha do título do atributo (ocupa as duas colunas)
        $tbody.append(`
      <tr class="label-row ${idx % 2 === 0 ? 'block-even' : 'block-odd'}">
        <td class="attr-name" colspan="2">
          <span class="attr-chip">${escapeHtml(rotulo)}</span>
        </td>
      </tr>
    `);

        // linha de valores
        $tbody.append(`
      <tr class="values-row ${idx % 2 === 0 ? 'block-even' : 'block-odd'}">
        <td>${escapeHtml(va)}</td>
        <td>${escapeHtml(vb)}</td>
      </tr>
    `);
      });

      $('#boxComparar').removeClass('d-none');
    }




    // busca os dados de um modelo (retorna Promise que resolve no objeto do modelo)
    function buscaDadosModelo(marca, modelo) {
      return $.ajax({
        url: 'sis/lista_dados_modelo.php',
        method: 'POST',
        dataType: 'json',
        data: {
          marca,
          modelo
        }
      }).then(function(data) {
        return Array.isArray(data) ? (data[0] || null) : data;
      });
    }

    $(function() {
      // --- seus handlers para carregar os modelos (mantive sua lógica) ---
      $('#selMarca-01').on('change', function() {
        const marca = $('#selMarca-01').val();
        const $modelo = $('#selModelo-01').prop('disabled', true);
        if (!marca) {
          $modelo.html('<option value="">Selecione a marca primeiro</option>');
          return;
        }
        $modelo.html('<option>Carregando...</option>');
        $.ajax({
            url: 'sis/lista_modelos.php',
            method: 'POST',
            dataType: 'json',
            data: {
              marca
            }
          })
          .done(function(data) {
            if (!Array.isArray(data) || data.length === 0) {
              $modelo.html('<option value="">Sem modelos para esta marca</option>');
              return;
            }
            const opts = ['<option value="">Selecione...</option>'].concat(data.map(r => {
              const modelo = escapeHtml(r.modelo ?? '');
              return `<option value="${modelo}">${modelo}</option>`;
            }));
            $modelo.html(opts.join('')).prop('disabled', false);
          })
          .fail(function(xhr) {
            console.error('Erro lista_modelos 01:', xhr?.status, xhr?.responseText);
            $modelo.html('<option value="">Erro ao carregar modelos</option>');
          })
      });

      $('#selMarca-02').on('change', function() {
        const marca = $('#selMarca-02').val();
        const $modelo = $('#selModelo-02').prop('disabled', true);
        if (!marca) {
          $modelo.html('<option value="">Selecione a marca primeiro</option>');
          return;
        }
        $modelo.html('<option>Carregando...</option>');
        $.ajax({
            url: 'sis/lista_modelos.php',
            method: 'POST',
            dataType: 'json',
            data: {
              marca
            }
          })
          .done(function(data) {
            if (!Array.isArray(data) || data.length === 0) {
              $modelo.html('<option value="">Sem modelos para esta marca</option>');
              return;
            }
            const opts = ['<option value="">Selecione...</option>'].concat(data.map(r => {
              const modelo = escapeHtml(r.modelo ?? '');
              return `<option value="${modelo}">${modelo}</option>`;
            }));
            $modelo.html(opts.join('')).prop('disabled', false);
          })
          .fail(function(xhr) {
            console.error('Erro lista_modelos 02:', xhr?.status, xhr?.responseText);
            $modelo.html('<option value="">Erro ao carregar modelos</option>');
          })
      });


      // --- botão Comparar ---
      $('#btnComparar').on('click', function() {
  const marca1  = $('#selMarca-01').val();
const modelo1 = $('#selModelo-01').val();
const marca2  = $('#selMarca-02').val();
const modelo2 = $('#selModelo-02').val();

const isEmpty = v => v == null || String(v).trim() === '';

const faltando = [];
let focusSel = null;

// Moto 1
if (isEmpty(marca1)) {
  faltando.push('Marca da Moto 1');
  focusSel ??= '#selMarca-01';
}
if (isEmpty(modelo1)) {
  faltando.push('Modelo da Moto 1');
  // Só foca no modelo se a marca 1 já estiver ok; senão mantenha foco na marca
  if (!focusSel && !isEmpty(marca1)) focusSel = '#selModelo-01';
}

// Moto 2
if (isEmpty(marca2)) {
  faltando.push('Marca da Moto 2');
  focusSel ??= '#selMarca-02';
}
if (isEmpty(modelo2)) {
  faltando.push('Modelo da Moto 2');
  if (!focusSel && !isEmpty(marca2)) focusSel = '#selModelo-02';
}

if (faltando.length) {
  abrirModalPreenchimento(faltando, focusSel); // usa sua função de modal
  return;
}


  // loading
  showLoader();

  $.when(
    buscaDadosModelo(marca1, modelo1),
    buscaDadosModelo(marca2, modelo2)
  ).done(function(a, b) {
    const dados1 = a, dados2 = b;
    hideLoader();
    if (!dados1 || !dados2) {
      $('#tComparar thead').html('<tr><th>Modelo A</th><th>Modelo B</th></tr>');
      $('#tComparar tbody').html('<tr><td colspan="2">Não foi possível obter os dados de um dos modelos.</td></tr>');
      return;
    }
    renderTabelaComparativo(dados1, dados2);
  }).fail(function(xhr) {
    console.error('Falha no comparativo:', xhr?.status, xhr?.responseText);
    hideLoader();
    $('#tComparar thead').html('<tr><th>Modelo A</th><th>Modelo B</th></tr>');
    $('#tComparar tbody').html('<tr><td colspan="2">Erro ao buscar dados para comparação.</td></tr>');
  });
});

    });

    function abrirModalPreenchimento(faltando, focusSelector){
  const $list = $('#modalPreenchimentoLista').empty();
  faltando.forEach(msg => $list.append(`<li>${escapeHtml(msg)}</li>`));

  const modalEl = document.getElementById('modalPreenchimento');
  const modal = bootstrap.Modal.getOrCreateInstance(modalEl);

  // ao fechar, foca no primeiro campo faltante
  if (focusSelector) {
    modalEl.addEventListener('hidden.bs.modal', function onHidden(){
      $(focusSelector).trigger('focus');
      modalEl.removeEventListener('hidden.bs.modal', onHidden);
    }, { once: true });
  }
  modal.show();
}

  </script>

  <!-- Modal: Campos obrigatórios -->
<div class="modal fade" id="modalPreenchimento" tabindex="-1" aria-labelledby="modalPreenchimentoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title" id="modalPreenchimentoLabel">Atenção</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <p>Para comparar as motos, preencha os seguintes campos:</p>
        <ul id="modalPreenchimentoLista" class="mb-0"></ul>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK, vou preencher</button>
      </div>
    </div>
  </div>
</div>

</body>

</html>