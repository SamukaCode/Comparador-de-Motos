# Duas Rodas — Comparador de Motos

Aplicação para comparar **duas motos** lado a lado (marca → modelo), exibindo
especificações como cilindrada, potência, peso, suspensão, tanque e consumo.

> Aviso: os dados podem conter imprecisões. Levantamento de informações: **2025**.

---

## Link para Visualização

- https://comparador-de-motos.vercel.app

## Funcionalidades

- Seleção de **marca** e **modelo** para duas motos
- Tabela comparativa com rótulos e valores
- Loader e mensagens amigáveis durante as buscas

---



## Estrutura de pastas

```shell
├── api/                       # Código PHP (executa como Serverless Function na Vercel)
│   ├── index.php              # Página principal
│   └── sis/                   # Scripts de backend
│       ├── conexao.php        # Conexão PDO (usa variáveis de ambiente)
│       ├── querys_bd.php      # Consultas ao banco
│       ├── lista_modelos.php
│       └── lista_dados_modelo.php
├── assets/                    # Arquivos estáticos
│   ├── css/
│   │   └── site.css
│   ├── logo.png
│   └── icons/
│       ├── moto.svg
│       └── moto-fav.ico
└── vercel.json                # Configuração de deploy
```

---

## Por que a pasta `api/`?

A **Vercel** executa arquivos em `api/` como **Serverless Functions**.  
Como este projeto usa **PHP** no backend, colocamos o `index.php` (e os demais
arquivos do servidor) dentro de `api/` para que a Vercel rode o PHP corretamente.

- Tudo que está em `api/**.php` roda no servidor (PHP).
- Tudo que está em `assets/` é servido como **estático** (CSS, imagens, ícones).
- O `vercel.json` apenas direciona a rota raiz `/` para `api/index.php`.

Isso permite um deploy simples: front (HTML/CSS/JS) + backend (PHP) na mesma
infraestrutura, sem precisar de servidor dedicado.

---

## Stacks

### Frontend

* HTML5
* CSS3 + Bootstrap 5.3
* JavaScript (ES6+) + jQuery 3.7

### Backend

* PHP 8 (PDO)
* PostgreSQL (Neon)
* JSON (respostas para o frontend)

### Infra / Deploy

* Vercel — Serverless Functions com `vercel-php`
* Variáveis de ambiente (Vercel)
* Assets estáticos servidos de `/assets`

---

## Licença

[MIT](https://choosealicense.com/licenses/mit/)

