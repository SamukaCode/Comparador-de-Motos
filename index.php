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

  <style>
    body { margin: 24px; }
  </style>
</head>
<body>
  <div class="container">
    <h1 class="mb-4">Lista de Motos</h1>

    <div class="row g-3 align-items-end mb-3">
      <div class="col-sm-6 col-md-4">
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

      
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-4">
        <label for="selModelo-01" class="form-label">Modelo</label>
        <select id="selModelo-01" class="form-select" disabled>
          <option value="">Selecione a marca primeiro</option>
        </select>
      </div>
    </div>


  </div>

    <div class="container">

    <div class="row g-3 align-items-end mb-3">
      <div class="col-sm-6 col-md-4">
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

      
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-4">
        <label for="selModelo-02" class="form-label">Modelo</label>
        <select id="selModelo-02" class="form-select" disabled>
          <option value="">Selecione a marca primeiro</option>
        </select>
      </div>
    </div>


  </div>

  
<div class="container mt-3">
  <button id="btnComparar" class="btn btn-primary" disabled>Comparar</button>
</div>

<div id="boxComparar" class="container mt-4 d-none">
  <h2 class="h5 mb-3">Comparativo</h2>
  <div class="table-responsive">
    <table id="tComparar" class="table table-striped table-bordered align-middle">
      <thead>
        <tr>
          <th style="width: 260px;">Atributo</th>
          <th id="thModel1">Modelo A</th>
          <th id="thModel2">Modelo B</th>
        </tr>
      </thead>
      <tbody><!-- preenchido via JS --></tbody>
    </table>
  </div>
</div>


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
  function escapeHtml(s){return String(s??'').replace(/[&<>"']/g,m=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[m]));}
  const fmtNum = new Intl.NumberFormat('pt-BR',{maximumFractionDigits:2});
  const fmtBRL = new Intl.NumberFormat('pt-BR',{style:'currency',currency:'BRL'});

  // mesmo mapa de atributos que você usa em renderTabelaModelo
  const MAPA_ATRIBUTOS = [
    ['id','ID'],
    ['marca','Marca'],
    ['modelo','Modelo'],
    ['cilindrada','Cilindrada'],
    ['potencia','Potência'],
    ['torque','Torque'],
    ['transmissao','Transmissão'],
    ['suspensao_dianteira','Suspensão dianteira'],
    ['suspensao_traseira','Suspensão traseira'],
    ['freios','Freios'],
    ['pneus','Pneus'],
    ['peso','Peso'],
    ['altura_do_assento','Altura do assento'],
    ['tanque','Tanque'],
    ['consumo_medio','Consumo médio'],
    ['preco','Preço'],
  ];

  function formatar(chave, val){
    if (val===null || typeof val==='undefined' || val==='') return '-';
    if (chave==='preco' && !isNaN(Number(val))) return fmtBRL.format(Number(val));
    if (['peso','altura_do_assento','tanque','consumo_medio'].includes(chave) && !isNaN(Number(val))) return fmtNum.format(Number(val));
    return String(val);
  }

  // render do comparativo lado a lado
  function renderTabelaComparativo(a, b){
    const $tbody = $('#tComparar tbody');
  $tbody.empty();

  MAPA_ATRIBUTOS.forEach(([key, rotulo])=>{
    const va = formatar(key, a?.[key]);
    const vb = formatar(key, b?.[key]);
    $tbody.append(
      `<tr>
         <td>${escapeHtml(rotulo)}</td>
         <td>${escapeHtml(va)}</td>
         <td>${escapeHtml(vb)}</td>
       </tr>`
    );
  });

  // cabeçalhos das colunas com "marca + modelo", se existirem
  $('#thModel1').text(a?.marca && a?.modelo ? `${a.marca} ${a.modelo}` : 'Modelo A');
  $('#thModel2').text(b?.marca && b?.modelo ? `${b.marca} ${b.modelo}` : 'Modelo B');

  $('#boxComparar').removeClass('d-none');
  }

  // busca os dados de um modelo (retorna Promise que resolve no objeto do modelo)
  function fetchDadosModelo(marca, modelo){
    return $.ajax({
      url: 'sis/lista_dados_modelo.php',
      method: 'POST',
      dataType: 'json',
      data: { marca, modelo }
    }).then(function(data){
      return Array.isArray(data) ? (data[0] || null) : data;
    });
  }

  // habilita/desabilita o botão Comparar
  function toggleBtnComparar(){
    const ok = $('#selMarca-01').val() && $('#selModelo-01').val() && $('#selMarca-02').val() && $('#selModelo-02').val();
    $('#btnComparar').prop('disabled', !ok);
  }

  $(function(){
    // --- seus handlers para carregar os modelos (mantive sua lógica) ---
    $('#selMarca-01').on('change', function () {
      const marca = $('#selMarca-01').val();
      const $modelo = $('#selModelo-01').prop('disabled', true);
      if (!marca){ $modelo.html('<option value="">Selecione a marca primeiro</option>'); toggleBtnComparar(); return; }
      $modelo.html('<option>Carregando...</option>');
      $.ajax({ url:'sis/lista_modelos.php', method:'POST', dataType:'json', data:{ marca }})
        .done(function(data){
          if (!Array.isArray(data) || data.length===0){ $modelo.html('<option value="">Sem modelos para esta marca</option>'); toggleBtnComparar(); return; }
          const opts = ['<option value="">Selecione...</option>'].concat(data.map(r=>{
            const modelo = escapeHtml(r.modelo ?? ''); return `<option value="${modelo}">${modelo}</option>`;
          }));
          $modelo.html(opts.join('')).prop('disabled', false);
        })
        .fail(function(xhr){ console.error('Erro lista_modelos 01:', xhr?.status, xhr?.responseText); $modelo.html('<option value="">Erro ao carregar modelos</option>'); })
        .always(toggleBtnComparar);
    });

    $('#selMarca-02').on('change', function () {
      const marca = $('#selMarca-02').val();
      const $modelo = $('#selModelo-02').prop('disabled', true);
      if (!marca){ $modelo.html('<option value="">Selecione a marca primeiro</option>'); toggleBtnComparar(); return; }
      $modelo.html('<option>Carregando...</option>');
      $.ajax({ url:'sis/lista_modelos.php', method:'POST', dataType:'json', data:{ marca }})
        .done(function(data){
          if (!Array.isArray(data) || data.length===0){ $modelo.html('<option value="">Sem modelos para esta marca</option>'); toggleBtnComparar(); return; }
          const opts = ['<option value="">Selecione...</option>'].concat(data.map(r=>{
            const modelo = escapeHtml(r.modelo ?? ''); return `<option value="${modelo}">${modelo}</option>`;
          }));
          $modelo.html(opts.join('')).prop('disabled', false);
        })
        .fail(function(xhr){ console.error('Erro lista_modelos 02:', xhr?.status, xhr?.responseText); $modelo.html('<option value="">Erro ao carregar modelos</option>'); })
        .always(toggleBtnComparar);
    });

    // monitora selects para habilitar o botão
    $('#selModelo-01, #selModelo-02').on('change', toggleBtnComparar);

    // --- botão Comparar ---
    $('#btnComparar').on('click', function(){
      const marca1  = $('#selMarca-01').val();
      const modelo1 = $('#selModelo-01').val();
      const marca2  = $('#selMarca-02').val();
      const modelo2 = $('#selModelo-02').val();

      if (!marca1 || !modelo1 || !marca2 || !modelo2) return;

      // loading
      $('#boxComparar').removeClass('d-none');
      $('#tComparar tbody').html('<tr><td colspan="3">Comparando modelos...</td></tr>');

      $.when(
        fetchDadosModelo(marca1, modelo1),
        fetchDadosModelo(marca2, modelo2)
      ).done(function(a, b){
        // $.when resolve com [dados] quando a função retorna Promise normal
        const dados1 = a; 
        const dados2 = b;
        if (!dados1 || !dados2){
          $('#tComparar tbody').html('<tr><td colspan="3">Não foi possível obter os dados de um dos modelos.</td></tr>');
          return;
        }
        renderTabelaComparativo(dados1, dados2);
      }).fail(function(xhr){
        console.error('Falha no comparativo:', xhr?.status, xhr?.responseText);
        $('#tComparar tbody').html('<tr><td colspan="3">Erro ao buscar dados para comparação.</td></tr>');
      });
    });
  });
</script>

</body>
</html>