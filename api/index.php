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
<link rel="icon" href="/assets/icons/moto-fav.ico">  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous">

    <link rel="stylesheet" href="/assets/css/site.css">

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
        url: '/api/sis/lista_dados_modelo.php',
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
            url: '/api/sis/lista_modelos.php',
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
            url: '/api/sis/lista_modelos.php',
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