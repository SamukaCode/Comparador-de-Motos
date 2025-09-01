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
  <title>Lista de Motos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous">

  <!-- HEAD (adicione/ajuste seu <style>) -->
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
.site-header{
  background: linear-gradient(180deg, var(--brand-red) 0%, var(--brand-red-d) 100%);
  padding: clamp(12px,2vw,20px) 0;
  box-shadow: 0 6px 16px rgba(0,0,0,.12);
}
.site-brand{
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 clamp(16px,4vw,32px);
  display: flex; align-items: center; gap: clamp(12px,2vw,20px);
}
.site-brand img{
  height: clamp(64px, 10vw, 120px);
  width: auto;
  border-radius: 16px;
  filter: drop-shadow(0 6px 18px rgba(0,0,0,.25));
}
.brand-title{ color:#fff; margin:0; font-weight:800; letter-spacing:.5px; }
.brand-sub  { color: rgba(255,255,255,.9); margin:0; font-size:.95rem; }

/* Se quiser o header fixo no topo, descomente: */
/* .site-header{ position: sticky; top: 0; z-index: 1030; } */

/* A seção principal agora é só um container (sem 30/70) */
.split-hero{ display:block; min-height: auto; }


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
    .btn-primary {
      --bs-btn-bg: var(--brand-red);
      --bs-btn-border-color: var(--brand-red);
      --bs-btn-hover-bg: var(--brand-red-d);
      --bs-btn-hover-border-color: var(--brand-red-d);
      --bs-btn-focus-shadow-rgb: 229, 57, 53;
    }

    .form-select:focus,
    .form-control:focus {
      border-color: var(--brand-red);
      box-shadow: 0 0 0 .25rem rgba(229, 57, 53, .25);
    }

    /* --- TABELA CUSTOM (atributo no meio + valores abaixo) --- */
    .table-compare.custom {
      border-collapse: separate;
      border-spacing: 0;
      overflow: hidden;
      border-radius: 12px;
      width: 60%;
    }

    .table-compare.custom thead th {
      text-align: center;
      background: #fff;
      position: sticky;
      top: 0;
      z-index: 2;
    }

    .table-compare.custom td,
    .table-compare.custom th {
      vertical-align: middle;
    }

    /* linha do rótulo (meio) */
    .table-compare .label-row td {
      border: 0;
      padding: 10px 8px 2px;
    }

    .table-compare .attr-name {
      text-align: center;
    }

    .table-compare .attr-chip {
    display: inline-block;
    background: var(--brand-red);
    color: #fff;
    font-weight: 600;
    font-size: 16px;
    line-height: 1;
    padding: 0.45rem .8rem;
    box-shadow: 0 4px 12px rgba(229, 57, 53, .18);
    width: 25%;
    border-radius: 999px;
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
.table-compare.custom{
  margin: 0 auto;                          /* centraliza */
  width: min(960px, 95%);                  /* máximo 960px, senão 95% */
  border-collapse: separate;               /* permite bordas por célula */
  border-spacing: 0;
}

/* Centralização horizontal + largura responsiva */
.table-compare.custom{
  margin: 0 auto;                          /* centraliza o <table> */
  width: clamp(320px, 90vw, 960px);        /* fluido até 960px */
  table-layout: fixed;                     /* colunas com mesma largura */
}

/* Centraliza texto de cabeçalhos e células */
.table-compare.custom th,
.table-compare.custom td{
  text-align: center;
}

/* chip centralizado de verdade (sem largura fixa) */
.table-compare .attr-name{ text-align: center; }
.table-compare .attr-chip{
  width: auto;               /* <- remova o width:25% anterior */
  margin-inline: auto;       /* centraliza o chip */
  display: inline-block;
}

/* opcional: deixa os valores bem centralizados e com separação suave */
.table-compare .values-row td{
  text-align: center;
}
.table-compare .values-row td + td{
  border-left: 1px dashed rgba(0,0,0,.12);
}




    /* responsivo: em telas pequenas, diminui um pouco a pílula */
    @media (max-width: 991.98px) {
      .table-compare .attr-chip {
        font-size: .85rem;
        padding: .4rem .7rem;
      }
    }
  </style>


</head>

<body>
<header class="site-header">
  <div class="site-brand">
    <img src="assets/logo.png" alt="Duas Rodas — Comparador de Motos">
    <div>
      <h1 class="brand-title">Duas Rodas</h1>
      <p class="brand-sub">Comparador de motos</p>
    </div>
  </div>
</header>

  <!-- SUBSTITUA O HEADER + CONTAINERS INICIAIS POR ESTE BLOCO -->
  <section class="split-hero">


    <!-- METADE 2: CONTEÚDO -->
    <div class="container-conteudo">
      <div class="container-fluid p-0">
        <h1 class="mb-4">Motos</h1>

        <div class="container-selecao">
          <div class="compare-wrap">
            <!-- COLUNA 1 -->
            <div class="compare-col">
              <div class="compare-head">
                <img class="moto-icon" src="assets/icons/moto.svg" alt="">
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
                <img class="moto-icon" src="assets/icons/moto.svg" alt="">
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
          <h2 class="h5 mb-3">Dados selecionados</h2>

          <!-- DESKTOP: Tabela -->
          <div class="table-compare-wrap table-responsive d-none d-lg-block">
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

          <!-- MOBILE: Accordion -->
          <div id="accComparar" class="accordion accordion-flush d-lg-none">
            <!-- preenchido via JS -->
          </div>
        </div>

      </div>
    </div>


  </section>


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
      ['consumo_medio', 'Consumo médio'],
      ['preco', 'Preço'],
    ];

    function formatar(chave, val) {
      if (val === null || typeof val === 'undefined' || val === '') return '-';
      if (chave === 'preco' && !isNaN(Number(val))) return fmtBRL.format(Number(val));
      if (['peso', 'altura_do_assento', 'tanque', 'consumo_medio'].includes(chave) && !isNaN(Number(val))) return fmtNum.format(Number(val));
      return String(val);
    }

    // Seções para o accordion (agrupam atributos)
    const SECOES = [
      {
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

    // Accordion mobile
    function renderAccordionComparativo(a, b) {
      const $acc = $('#accComparar').empty();
      SECOES.forEach((sec, idx) => {
        const corpo = sec.itens.map(([key, rotulo]) => {
          const va = formatar(key, a?.[key]);
          const vb = formatar(key, b?.[key]);
          return `
        <div class="row py-2 border-bottom">
          <div class="col-12 small text-muted mb-1">${escapeHtml(rotulo)}</div>
          <div class="col-6"><strong>${escapeHtml(va)}</strong></div>
          <div class="col-6"><strong>${escapeHtml(vb)}</strong></div>
        </div>`;
        }).join('');

        $acc.append(`
      <div class="accordion-item">
        <h2 class="accordion-header" id="h${idx}">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#c${idx}" aria-expanded="false" aria-controls="c${idx}">
            ${escapeHtml(sec.titulo)}
          </button>
        </h2>
        <div id="c${idx}" class="accordion-collapse collapse" aria-labelledby="h${idx}" data-bs-parent="#accComparar">
          <div class="accordion-body">${corpo}</div>
        </div>
      </div>`);
      });
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
    const va = formatar(key, a?.[key]);
    const vb = formatar(key, b?.[key]);

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

  // também atualiza o accordion mobile (se estiver usando)
  renderAccordionComparativo(a, b);

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

    // habilita/desabilita o botão Comparar
    function toggleBtnComparar() {
      const ok = $('#selMarca-01').val() && $('#selModelo-01').val() && $('#selMarca-02').val() && $('#selModelo-02').val();
      $('#btnComparar').prop('disabled', !ok);
    }

    $(function() {
      // --- seus handlers para carregar os modelos (mantive sua lógica) ---
      $('#selMarca-01').on('change', function() {
        const marca = $('#selMarca-01').val();
        const $modelo = $('#selModelo-01').prop('disabled', true);
        if (!marca) {
          $modelo.html('<option value="">Selecione a marca primeiro</option>');
          toggleBtnComparar();
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
              toggleBtnComparar();
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
          .always(toggleBtnComparar);
      });

      $('#selMarca-02').on('change', function() {
        const marca = $('#selMarca-02').val();
        const $modelo = $('#selModelo-02').prop('disabled', true);
        if (!marca) {
          $modelo.html('<option value="">Selecione a marca primeiro</option>');
          toggleBtnComparar();
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
              toggleBtnComparar();
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
          .always(toggleBtnComparar);
      });

      // monitora selects para habilitar o botão
      $('#selModelo-01, #selModelo-02').on('change', toggleBtnComparar);

      // --- botão Comparar ---
      $('#btnComparar').on('click', function() {
        const marca1 = $('#selMarca-01').val();
        const modelo1 = $('#selModelo-01').val();
        const marca2 = $('#selMarca-02').val();
        const modelo2 = $('#selModelo-02').val();

        if (!marca1 || !modelo1 || !marca2 || !modelo2) return;

        // loading
        $('#boxComparar').removeClass('d-none');
        $('#tComparar tbody').html('<tr><td colspan="3">Comparando modelos...</td></tr>');

        $.when(
          buscaDadosModelo(marca1, modelo1),
          buscaDadosModelo(marca2, modelo2)
        ).done(function(a, b) {
          // $.when resolve com [dados] quando a função retorna Promise normal
          const dados1 = a;
          const dados2 = b;
          if (!dados1 || !dados2) {
            $('#tComparar tbody').html('<tr><td colspan="3">Não foi possível obter os dados de um dos modelos.</td></tr>');
            return;
          }
          renderTabelaComparativo(dados1, dados2);
        }).fail(function(xhr) {
          console.error('Falha no comparativo:', xhr?.status, xhr?.responseText);
          $('#tComparar tbody').html('<tr><td colspan="3">Erro ao buscar dados para comparação.</td></tr>');
        });
      });
    });
  </script>

</body>

</html>