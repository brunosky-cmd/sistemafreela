# Relatorio Tecnico - Sistema Freela

## 1. Objetivo do sistema

O projeto e uma aplicacao web em PHP para intermediar a oferta e a procura de servicos. O sistema possui dois perfis principais:

- Prestador: usuario que publica servicos, gerencia suas ofertas e avalia candidaturas recebidas.
- Buscador: usuario que pesquisa servicos publicados, visualiza detalhes e se candidata a oportunidades.

A aplicacao funciona como um marketplace simples de servicos/vagas, com cadastro, login, perfis, publicacao de servicos, candidatura e controle de status da candidatura.

## 2. Funcionalidades existentes

### Autenticacao e sessao

- Cadastro de usuarios com email, senha, tipo de usuario, telefone, CEP e trabalho/profissao.
- Login por email e senha.
- Logout.
- Controle de sessao com `usuario_id`, `tipo_usuario`, `email` e `nome`.
- Restricao de acesso por tipo de usuario usando `requireUserType`.

### Pagina inicial e busca

- Listagem de todos os servicos publicados.
- Busca por titulo do servico, categoria ou email do prestador.
- Exibicao resumida de titulo, categoria, modalidade, preco e prestador.
- Navegacao para detalhes do servico.

### Servicos

- Prestador pode criar servico.
- Prestador pode listar seus proprios servicos.
- Prestador pode editar servico proprio.
- Prestador pode excluir servico proprio.
- Qualquer usuario pode visualizar detalhes de um servico.
- Buscador logado pode se candidatar a servico.

### Candidaturas

- Buscador pode criar candidatura para um servico.
- Buscador pode visualizar suas candidaturas.
- Prestador pode visualizar candidaturas de um servico proprio.
- Prestador pode aceitar ou recusar candidaturas.
- Status previstos: `aguardando`, `aceito`, `recusado`.

### Perfis

- Usuario logado pode visualizar perfil.
- Usuario logado pode visualizar perfil de outros usuarios.
- Prestador pode editar dados do perfil de prestador.
- Buscador pode editar dados do perfil de buscador.
- Usuario pode excluir seu proprio perfil/conta.

## 3. Fluxo do prestador

1. Acessa `cadastro.php`.
2. Informa email, senha, tipo `prestador`, telefone, CEP e trabalho.
3. Apos cadastro, acessa `login.php`.
4. Realiza login e e redirecionado para `index.php`.
5. Na pagina inicial, visualiza opcoes de prestador:
   - Criar servico.
   - Meus servicos.
   - Perfil.
   - Editar perfil.
   - Logout.
6. Em `criar_servico.php`, publica um servico com titulo, categoria, modalidade, preco, cidade, UF e descricao.
7. Em `meus_servicos.php`, lista os servicos publicados.
8. Para cada servico, pode:
   - Editar em `editar_servico.php?id=...`.
   - Excluir em `excluir_servico.php?id=...`.
   - Ver candidaturas em `candidaturas.php?servico_id=...`.
9. Em `candidaturas.php`, visualiza candidatos, dados de perfil e status.
10. Pode aceitar em `aceitar.php?id=...` ou recusar em `recusar.php?id=...`.
11. Pode consultar o perfil do candidato.
12. Pode editar seu proprio perfil em `editar_prestador.php`.
13. Pode excluir a conta em `excluir_usuario.php`.

## 4. Fluxo do buscador

1. Acessa `cadastro.php`.
2. Informa email, senha, tipo `buscador`, telefone, CEP e trabalho.
3. Realiza login em `login.php`.
4. Na pagina inicial, pesquisa e visualiza servicos disponiveis.
5. Abre um servico em `servico.php?id=...`.
6. Se ainda nao se candidatou, pode clicar em `Candidatar-se`.
7. A candidatura e registrada em `candidatar.php?servico_id=...`.
8. Apos candidatura, o status aparece como aguardando.
9. Em `minhas_candidaturas.php`, visualiza todas as candidaturas realizadas.
10. Se a candidatura for aceita, pode acessar o perfil do prestador.
11. Pode editar seu perfil em `editar_buscador.php`.
12. Pode excluir a conta em `excluir_usuario.php`.

## 5. Estrutura do banco de dados

Nao ha arquivo SQL no projeto. A estrutura abaixo foi inferida a partir das queries nos models.

### Banco

- Nome usado pela aplicacao: `sistema_servicos`.
- Conexao configurada em `config/database.php` com host `localhost`, usuario `root`, senha vazia e charset `utf8mb4`.

### Tabela `usuarios`

Campos inferidos:

- `id`: chave primaria.
- `email`: email do usuario.
- `nome`: nome do usuario ou empresa.
- `senha`: senha do usuario.
- `tipo_usuario`: `prestador` ou `buscador`.

Relacionamentos:

- `usuarios.id` e referenciado por `servicos.usuario_id`.
- `usuarios.id` e referenciado por `perfil_prestador.usuario_id`.
- `usuarios.id` e referenciado por `perfil_buscador.usuario_id`.
- `usuarios.id` e referenciado por `candidaturas.buscador_id`.
- `usuarios.id` e usado em `avaliacoes.avaliador_id` e `avaliacoes.avaliado_id`.

### Tabela `perfil_prestador`

Campos inferidos:

- `usuario_id`: referencia `usuarios.id`.
- `trabalho`.
- `telefone`.
- `cep`.
- `rua`.
- `bairro`.
- `cidade`.
- `quem_sou`.
- `categoria`.

### Tabela `perfil_buscador`

Campos inferidos:

- `usuario_id`: referencia `usuarios.id`.
- `cep`.
- `telefone`.
- `trabalho`.
- `rua`.
- `bairro`.
- `cidade`.
- `categoria`.
- `quem_sou`.
- `valor_hora`.
- `salario`.

### Tabela `servicos`

Campos inferidos:

- `id`: chave primaria.
- `usuario_id`: referencia o prestador em `usuarios.id`.
- `titulo`.
- `descricao`.
- `categoria`.
- `modalidade`.
- `preco`.
- `cidade`.
- `uf`.
- `data_criacao`: usada para ordenacao.

### Tabela `candidaturas`

Campos inferidos:

- `id`: chave primaria.
- `servico_id`: referencia `servicos.id`.
- `buscador_id`: referencia `usuarios.id`.
- `status`: status da candidatura.
- `data_candidatura`: usada para ordenacao.

Regras observadas:

- Uma candidatura e criada com `servico_id` e `buscador_id`.
- O status padrao provavelmente deve ser `aguardando`, pois o insert nao informa status.
- O sistema evita duplicidade em nivel de aplicacao verificando se ja existe candidatura para o mesmo servico e buscador.

### Tabela `avaliacoes`

A tabela e mencionada apenas na exclusao de usuario:

- `avaliador_id`.
- `avaliado_id`.

Nao foram encontradas funcionalidades de avaliacao implementadas nas telas/controllers atuais.

## 6. Arquivos principais

### Raiz do projeto

- `index.php`: rota da pagina inicial.
- `login.php`: rota de login.
- `cadastro.php`: rota de cadastro.
- `logout.php`: encerra a sessao.
- `servico.php`: detalhes de servico.
- `criar_servico.php`: criacao de servico.
- `meus_servicos.php`: lista servicos do prestador.
- `editar_servico.php`: edicao de servico.
- `excluir_servico.php`: exclusao de servico.
- `candidatar.php`: cria candidatura.
- `candidaturas.php`: lista candidaturas recebidas por um servico.
- `minhas_candidaturas.php`: lista candidaturas feitas pelo buscador.
- `aceitar.php`: aceita candidatura.
- `recusar.php`: recusa candidatura.
- `perfil.php`: exibe perfil.
- `editar_prestador.php`: edita perfil de prestador.
- `editar_buscador.php`: edita perfil de buscador.
- `excluir_usuario.php`: exclui usuario logado.

### Configuracao e infraestrutura

- `config/database.php`: conexao MySQLi.
- `core/bootstrap.php`: carrega configuracoes, helpers e autoload.
- `core/helpers.php`: sessao, redirect, escaping, controle de acesso e helpers de modalidade.

### Controllers

- `controllers/HomeController.php`: pagina inicial e busca.
- `controllers/AuthController.php`: login, cadastro e logout.
- `controllers/ServiceController.php`: CRUD de servicos e detalhes.
- `controllers/ApplicationController.php`: candidaturas e atualizacao de status.
- `controllers/ProfileController.php`: exibicao, edicao e exclusao de perfil.

### Models

- `models/BaseModel.php`: wrapper basico para queries com prepared statements.
- `models/User.php`: usuarios e perfis.
- `models/Service.php`: servicos.
- `models/Application.php`: candidaturas.

### Views

- `views/home/index.php`: tela inicial.
- `views/auth/login.php`: login.
- `views/auth/register.php`: cadastro.
- `views/services/create.php`: criacao de servico.
- `views/services/edit.php`: edicao de servico.
- `views/services/show.php`: detalhe do servico.
- `views/services/mine.php`: servicos do prestador.
- `views/applications/for_service.php`: candidaturas recebidas.
- `views/applications/mine.php`: candidaturas do buscador.
- `views/profiles/show.php`: perfil.
- `views/profiles/edit_prestador.php`: edicao de prestador.
- `views/profiles/edit_buscador.php`: edicao de buscador.

### Assets

- `CSS/*.css`: estilos por tela.
- `JS/script.js`: comportamento do menu/dropdown e utilitarios de busca.

## 7. Problemas encontrados

### Criticos

- Senhas sao armazenadas e comparadas em texto puro. O login usa `SELECT * FROM usuarios WHERE email = ? AND senha = ?`. Isso deve ser substituido por `password_hash` e `password_verify`.
- Acoes destrutivas e mudancas de estado usam GET: excluir usuario, excluir servico, candidatar, aceitar e recusar. Isso expõe o sistema a CSRF e execucao acidental por links.
- Nao ha tokens CSRF em formularios ou acoes sensiveis.
- Cadastro de usuario e criacao de perfil nao usam transacao. Se o usuario for criado e o perfil falhar, o banco fica inconsistente.
- Exclusao de usuario remove dados de varias tabelas sem transacao.

### Altos

- Nao ha validacao robusta de entrada no servidor. Campos obrigatorios, formatos, limites, tipos numericos, UF e email dependem quase totalmente do HTML ou nao sao validados.
- Nao ha restricao clara de unicidade para email no codigo.
- Nao ha garantia de unicidade de candidatura por `(servico_id, buscador_id)` no banco.
- Nao ha tratamento de erro detalhado nos models; `prepare` com falha retorna `false` ou lista vazia, escondendo problemas de schema/query.
- O helper `modalidadeBanco` contem texto corrompido para "Hibrido", indicando problema de encoding/dados.
- Varias strings aparecem com caracteres quebrados, como `ServiÃ§o`, `VocÃª`, `HÃ­brido`. Isso indica inconsistencia de codificacao entre arquivos, editor e/ou banco.

### Medios

- O sistema usa arquitetura MVC, mas as rotas sao arquivos soltos na raiz. Funciona, porem dificulta padronizacao, middlewares e evolucao.
- Nao existe arquivo de schema/migracoes do banco.
- Nao ha layout/template compartilhado; navbar e estrutura HTML se repetem em varias views.
- Nao ha paginacao na listagem de servicos e candidaturas.
- Nao ha logs de erro ou auditoria para acoes importantes.
- Nao ha testes automatizados.
- Nao ha separacao de configuracoes por ambiente. Credenciais de banco estao fixas no codigo.
- Nao ha recuperacao de senha, alteracao de senha ou confirmacao de email.
- O nome inicial do usuario e salvo como string vazia no cadastro, embora o sistema exiba nome em varios pontos.
- A tabela `avaliacoes` e referenciada na exclusao, mas nao ha funcionalidade correspondente implementada.

### Baixos

- Titulos e textos ainda usam nomes genericos como `Meu Site em PHP`.
- O JavaScript do dropdown aparece inline em uma view e tambem existe `JS/script.js`.
- CSS usa pasta `CSS`, mas as views referenciam `css/...`; em Windows isso funciona, mas pode falhar em ambiente Linux por diferenca de caixa.
- Algumas mensagens de erro retornam texto direto no controller em vez de uma view padronizada.

## 8. Melhorias recomendadas

### Seguranca

- Trocar senha em texto puro por hash:
  - Cadastro: `password_hash($senha, PASSWORD_DEFAULT)`.
  - Login: buscar usuario por email e validar com `password_verify`.
- Usar POST para acoes de mudanca de estado:
  - excluir servico;
  - excluir usuario;
  - candidatar;
  - aceitar candidatura;
  - recusar candidatura.
- Implementar token CSRF em todos os formularios e acoes sensiveis.
- Regenerar ID de sessao apos login com `session_regenerate_id(true)`.
- Validar autorizacao sempre no backend, mantendo as verificacoes atuais de dono do servico.
- Configurar headers de seguranca basicos.

### Banco de dados

- Criar arquivo SQL ou migracoes versionadas.
- Adicionar chaves estrangeiras e `ON DELETE` apropriados.
- Adicionar `UNIQUE` em `usuarios.email`.
- Adicionar `UNIQUE` em `candidaturas(servico_id, buscador_id)`.
- Definir `DEFAULT 'aguardando'` em `candidaturas.status`.
- Definir tipos adequados:
  - valores monetarios como `DECIMAL`;
  - datas como `DATETIME`;
  - UF como `CHAR(2)`.
- Usar transacoes para cadastro, exclusao de usuario e exclusao de servico.

### Qualidade de codigo

- Corrigir encoding dos arquivos para UTF-8 sem corromper acentos.
- Corrigir a regra de `modalidadeBanco`/`modalidadeLabel`.
- Centralizar layout comum em componentes/includes.
- Padronizar nomes de pastas em minusculo ou ajustar referencias para respeitar case-sensitive.
- Criar uma camada de configuracao por ambiente usando variaveis de ambiente.
- Melhorar tratamento de erros no banco e expor mensagens amigaveis ao usuario.
- Criar testes para:
  - login;
  - cadastro;
  - permissao por tipo de usuario;
  - CRUD de servicos;
  - candidatura unica;
  - aceite/recusa apenas pelo dono do servico.

### Produto e UX

- Alterar nome e identidade visual do sistema para algo especifico.
- Adicionar filtros por categoria, cidade, UF, modalidade e preco.
- Adicionar paginacao.
- Adicionar tela de detalhes do prestador com servicos publicados.
- Adicionar cancelamento de candidatura pelo buscador.
- Adicionar notificacoes para mudancas de status.
- Adicionar historico de contratacoes ou fechamento de servico.
- Implementar avaliacoes, se a tabela `avaliacoes` for mantida.

## 9. Casos de uso

### UC01 - Cadastrar usuario

- Ator: visitante.
- Pre-condicao: visitante nao autenticado.
- Fluxo principal:
  1. Visitante acessa cadastro.
  2. Informa email, senha, tipo de usuario, telefone, CEP e trabalho.
  3. Sistema cria usuario.
  4. Sistema cria perfil conforme o tipo.
  5. Sistema informa sucesso.
- Pos-condicao: usuario cadastrado com perfil inicial.

### UC02 - Realizar login

- Ator: usuario cadastrado.
- Pre-condicao: usuario existente.
- Fluxo principal:
  1. Usuario informa email e senha.
  2. Sistema valida credenciais.
  3. Sistema cria sessao.
  4. Usuario e redirecionado para a pagina inicial.
- Pos-condicao: usuario autenticado.

### UC03 - Publicar servico

- Ator: prestador.
- Pre-condicao: prestador autenticado.
- Fluxo principal:
  1. Prestador acessa criacao de servico.
  2. Preenche dados do servico.
  3. Sistema grava o servico vinculado ao prestador.
  4. Sistema exibe mensagem de sucesso.
- Pos-condicao: servico disponivel na listagem.

### UC04 - Pesquisar servicos

- Ator: visitante, buscador ou prestador.
- Pre-condicao: nenhuma.
- Fluxo principal:
  1. Ator acessa pagina inicial.
  2. Informa termo de busca.
  3. Sistema filtra por titulo, categoria ou email do prestador.
  4. Sistema exibe resultados.
- Pos-condicao: resultados exibidos.

### UC05 - Candidatar-se a servico

- Ator: buscador.
- Pre-condicao: buscador autenticado e servico existente.
- Fluxo principal:
  1. Buscador abre detalhes do servico.
  2. Clica em candidatar-se.
  3. Sistema verifica candidatura existente.
  4. Sistema cria candidatura.
  5. Sistema volta para detalhes com status atualizado.
- Pos-condicao: candidatura registrada.

### UC06 - Gerenciar candidaturas recebidas

- Ator: prestador.
- Pre-condicao: prestador autenticado e dono do servico.
- Fluxo principal:
  1. Prestador acessa seus servicos.
  2. Abre candidaturas de um servico.
  3. Visualiza dados dos candidatos.
  4. Aceita ou recusa uma candidatura.
  5. Sistema atualiza status.
- Pos-condicao: candidatura com status alterado.

### UC07 - Editar perfil

- Ator: prestador ou buscador.
- Pre-condicao: usuario autenticado.
- Fluxo principal:
  1. Usuario acessa edicao de perfil correspondente ao seu tipo.
  2. Atualiza dados.
  3. Sistema salva alteracoes.
  4. Sistema exibe mensagem de sucesso.
- Pos-condicao: perfil atualizado.

### UC08 - Excluir conta

- Ator: usuario autenticado.
- Pre-condicao: usuario autenticado.
- Fluxo principal:
  1. Usuario solicita exclusao.
  2. Sistema remove avaliacoes, candidaturas, servicos, perfis e usuario.
  3. Sistema encerra sessao.
  4. Sistema redireciona para pagina inicial.
- Pos-condicao: conta removida.

## 10. Requisitos funcionais

- RF01: O sistema deve permitir cadastro de usuarios.
- RF02: O sistema deve permitir escolher tipo de usuario entre prestador e buscador.
- RF03: O sistema deve permitir login e logout.
- RF04: O sistema deve manter sessao de usuario autenticado.
- RF05: O sistema deve permitir que prestadores criem servicos.
- RF06: O sistema deve permitir que prestadores editem apenas seus proprios servicos.
- RF07: O sistema deve permitir que prestadores excluam apenas seus proprios servicos.
- RF08: O sistema deve listar servicos publicados na pagina inicial.
- RF09: O sistema deve permitir busca por servico, categoria ou usuario.
- RF10: O sistema deve exibir detalhes de um servico.
- RF11: O sistema deve permitir candidatura apenas para usuarios do tipo buscador.
- RF12: O sistema deve impedir candidatura duplicada do mesmo buscador no mesmo servico.
- RF13: O sistema deve permitir que buscadores visualizem suas candidaturas.
- RF14: O sistema deve permitir que prestadores visualizem candidaturas de seus servicos.
- RF15: O sistema deve permitir que prestadores aceitem candidaturas.
- RF16: O sistema deve permitir que prestadores recusem candidaturas.
- RF17: O sistema deve permitir visualizacao de perfis.
- RF18: O sistema deve permitir edicao de perfil conforme o tipo de usuario.
- RF19: O sistema deve permitir exclusao da propria conta.
- RF20: O sistema deve exibir status da candidatura.

## 11. Requisitos nao funcionais

- RNF01: O sistema deve proteger senhas com hash seguro.
- RNF02: O sistema deve usar prepared statements para consultas com parametros.
- RNF03: O sistema deve validar entradas no servidor.
- RNF04: O sistema deve proteger acoes sensiveis contra CSRF.
- RNF05: O sistema deve restringir acessos por autenticacao e tipo de usuario.
- RNF06: O sistema deve manter integridade referencial no banco de dados.
- RNF07: O sistema deve usar transacoes em operacoes compostas.
- RNF08: O sistema deve armazenar e servir arquivos em UTF-8 corretamente.
- RNF09: O sistema deve permitir configuracao por ambiente.
- RNF10: O sistema deve ter tratamento de erros consistente.
- RNF11: O sistema deve ser responsivo para uso em diferentes tamanhos de tela.
- RNF12: O sistema deve ser testavel com testes automatizados.
- RNF13: O sistema deve registrar erros relevantes para diagnostico.
- RNF14: O sistema deve ter desempenho adequado em listagens com paginacao quando houver muitos registros.
- RNF15: O sistema deve evitar duplicidades por restricoes de banco, nao apenas por regra de aplicacao.

## 12. Conclusao

O projeto ja implementa o nucleo funcional de um marketplace simples de servicos: cadastro, login, perfis, publicacao, busca, candidatura e aceite/recusa. A separacao em controllers, models e views e um ponto positivo e facilita evolucao.

As principais pendencias sao de seguranca, integridade de dados e padronizacao. Antes de uso real em producao, e essencial corrigir senhas em texto puro, CSRF, operacoes por GET, ausencia de transacoes, falta de schema versionado e problemas de encoding.
