# Relatorio Tecnico - Refatoracao Arquitetural de Rotas

## 1. Estrutura atual encontrada antes da migracao

O projeto estava organizado com rotas PHP soltas na raiz e camadas internas separadas em diretorios simples:

```text
sistemafreela/
├── aceitar.php
├── cadastro.php
├── candidatar.php
├── candidaturas.php
├── criar_servico.php
├── editar_buscador.php
├── editar_prestador.php
├── editar_servico.php
├── excluir_servico.php
├── excluir_usuario.php
├── index.php
├── login.php
├── logout.php
├── meus_servicos.php
├── minhas_candidaturas.php
├── perfil.php
├── recusar.php
├── servico.php
├── config/
├── controllers/
├── core/
├── CSS/
├── JS/
├── models/
└── views/
```

## 2. Funcionalidades identificadas

- Home/listagem de servicos.
- Busca de servicos por titulo, categoria ou email do prestador.
- Cadastro de usuario.
- Login e logout.
- Visualizacao de detalhes de servico.
- Criacao, edicao, exclusao e listagem de servicos do prestador.
- Candidatura de buscador em servico.
- Listagem de candidaturas do buscador.
- Listagem de candidaturas recebidas pelo prestador.
- Aceite e recusa de candidaturas.
- Visualizacao de perfil.
- Edicao de perfil de prestador.
- Edicao de perfil de buscador.
- Exclusao da propria conta.

Nao foram encontrados arquivos ou controllers implementados para `notificacoes`, `avaliacoes`, `admin`, `usuarios`, `relatorios` ou finalizacao de candidaturas. Essas rotas foram registradas como 404 explicito para documentar que os modulos ainda nao existem, sem criar regra de negocio nova.

## 3. Nova estrutura implementada

```text
sistemafreela/
├── app/
│   ├── config/
│   │   └── database.php
│   ├── controllers/
│   │   ├── ApplicationController.php
│   │   ├── AuthController.php
│   │   ├── HomeController.php
│   │   ├── ProfileController.php
│   │   └── ServiceController.php
│   ├── core/
│   │   ├── bootstrap.php
│   │   └── helpers.php
│   ├── models/
│   │   ├── Application.php
│   │   ├── BaseModel.php
│   │   ├── Service.php
│   │   └── User.php
│   └── views/
│       ├── applications/
│       ├── auth/
│       ├── home/
│       ├── profiles/
│       └── services/
├── database/
├── public/
│   ├── .htaccess
│   ├── index.php
│   └── assets/
│       ├── css/
│       ├── js/
│       └── uploads/
├── routes/
│   └── web.php
├── RELATORIO_TECNICO.md
└── RELATORIO_REFATORACAO_ROTAS.md
```

## 4. Arquivos movidos

### Camadas da aplicacao

| Origem | Destino |
| --- | --- |
| `config/database.php` | `app/config/database.php` |
| `controllers/*` | `app/controllers/*` |
| `models/*` | `app/models/*` |
| `views/*` | `app/views/*` |
| `core/bootstrap.php` | `app/core/bootstrap.php` |
| `core/helpers.php` | `app/core/helpers.php` |

### Assets

| Origem | Destino |
| --- | --- |
| `CSS/*` | `public/assets/css/*` |
| `JS/*` | `public/assets/js/*` |

### Rotas antigas removidas da raiz

Os arquivos abaixo foram substituidos por entradas centralizadas em `routes/web.php` e removidos da raiz:

- `aceitar.php`
- `cadastro.php`
- `candidatar.php`
- `candidaturas.php`
- `criar_servico.php`
- `editar_buscador.php`
- `editar_prestador.php`
- `editar_servico.php`
- `excluir_servico.php`
- `excluir_usuario.php`
- `index.php`
- `login.php`
- `logout.php`
- `meus_servicos.php`
- `minhas_candidaturas.php`
- `perfil.php`
- `recusar.php`
- `servico.php`

## 5. Rotas mapeadas

| Funcionalidade antiga | Nova rota | Controller/metodo |
| --- | --- | --- |
| `index.php` | `/` e `/home` | `HomeController::index` |
| Listagem de vagas | `/vagas` | `HomeController::index` |
| `login.php` | `/login` | `AuthController::login` |
| `cadastro.php` | `/cadastro` | `AuthController::register` |
| `logout.php` | `/logout` | `AuthController::logout` |
| `criar_servico.php` | `/vagas/criar` | `ServiceController::create` |
| `editar_servico.php?id=...` | `/vagas/editar?id=...` | `ServiceController::edit` |
| `excluir_servico.php?id=...` | `/vagas/excluir?id=...` | `ServiceController::delete` |
| `servico.php?id=...` | `/vagas/detalhes?id=...` | `ServiceController::show` |
| `meus_servicos.php` | `/vagas/minhas` | `ServiceController::mine` |
| `candidaturas.php?servico_id=...` | `/candidaturas?servico_id=...` | `ApplicationController::index` |
| `minhas_candidaturas.php` | `/candidaturas` | `ApplicationController::index` |
| `candidatar.php?servico_id=...` | `/candidaturas/criar?servico_id=...` | `ApplicationController::create` |
| `aceitar.php?id=...` | `/candidaturas/aceitar?id=...` | `ApplicationController::accept` |
| `recusar.php?id=...` | `/candidaturas/cancelar?id=...` | `ApplicationController::reject` |
| `perfil.php?id=...` | `/perfil?id=...` | `ProfileController::show` |
| `editar_prestador.php` | `/perfil/editar` | `ProfileController::edit` |
| `editar_buscador.php` | `/perfil/editar` | `ProfileController::edit` |
| `excluir_usuario.php` | `/perfil/excluir` | `ProfileController::delete` |

Rotas desejadas mas sem funcionalidade existente foram registradas como 404 explicito:

- `/notificacoes`
- `/avaliacoes`
- `/admin`
- `/admin/usuarios`
- `/admin/vagas`
- `/admin/relatorios`
- `/candidaturas/finalizar`

## 6. Alteracoes tecnicas realizadas

- Criado `public/index.php` como Front Controller unico.
- Criado `routes/web.php` com registro centralizado de rotas GET e POST.
- Criado `public/.htaccess` para redirecionar URLs amigaveis para `public/index.php`.
- Movidos controllers, models, views, config e core para `app/`.
- Movidos CSS e JS para `public/assets/`.
- Criada pasta `public/assets/uploads/`.
- Criada pasta `database/`.
- Atualizado autoload em `app/core/bootstrap.php` para continuar carregando controllers e models no novo local.
- Atualizado `app/core/helpers.php` com:
  - `basePath()`
  - `url()`
  - `asset()`
- Atualizados redirects internos para rotas amigaveis.
- Atualizados links das views para `url('/rota')`.
- Atualizados paths de CSS/JS para `asset('css/...')` e `asset('js/...')`.
- Adicionado `ApplicationController::index()` para manter em uma unica rota o comportamento de:
  - candidaturas do buscador;
  - candidaturas recebidas pelo prestador quando `servico_id` esta presente.
- Adicionado `ProfileController::edit()` para despachar a edicao para prestador ou buscador conforme o tipo da sessao.

## 7. Impactos da migracao

- A URL base recomendada passa a ser `http://localhost/sistemafreela/public`.
- Os arquivos `.php` antigos na raiz nao existem mais; links antigos como `login.php` deixam de ser o caminho principal.
- O Apache precisa permitir `mod_rewrite` para as URLs amigaveis funcionarem via `.htaccess`.
- Caso o projeto seja publicado em producao, o DocumentRoot ideal deve apontar diretamente para `public/`.
- Rotas que exigem sessao continuam redirecionando para `/login`.
- Acoes sensiveis continuam usando GET onde o sistema original usava GET, porque a regra de negocio nao foi alterada nesta refatoracao.
- Problemas existentes de encoding e seguranca documentados no relatorio anterior nao foram corrigidos, por estarem fora do escopo de reorganizacao arquitetural.

## 8. Validacoes executadas

### Sintaxe PHP

Executado:

```text
C:\xampp\php\php.exe -l
```

Resultado:

- Nenhum erro de sintaxe encontrado em controllers.
- Nenhum erro de sintaxe encontrado em models.
- Nenhum erro de sintaxe encontrado em views.
- Nenhum erro de sintaxe encontrado em `public/index.php`.
- Nenhum erro de sintaxe encontrado em `routes/web.php`.

### Testes HTTP via Apache local

Base usada:

```text
http://localhost/sistemafreela/public
```

| Rota testada | Resultado |
| --- | --- |
| `/login` | 200 |
| `/cadastro` | 200 |
| `/home` | 200 |
| `/vagas` | 200 |
| `/vagas/criar` | 302 para login quando sem sessao |
| `/perfil` | 302 para login quando sem sessao |
| `/candidaturas` | 302 para login quando sem sessao |
| `/notificacoes` | 404 explicito, modulo inexistente |
| `/avaliacoes` | 404 explicito, modulo inexistente |
| `/admin` | 404 explicito, modulo inexistente |
| `/assets/css/style.css` | 200 |
| `/assets/js/script.js` | 200 |

## 9. Conclusao

A refatoracao arquitetural foi concluida com Front Controller, rotas centralizadas e separacao de camadas em `app/`, `public/`, `routes/` e `database/`. A logica de negocio existente foi preservada e os endpoints antigos foram mapeados para URLs amigaveis.

As proximas melhorias recomendadas sao migrar acoes de estado para POST com CSRF, adicionar controllers reais para notificacoes/avaliacoes/admin quando esses modulos forem implementados e configurar o Apache para usar `public/` como DocumentRoot em ambiente definitivo.
