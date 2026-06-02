<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title><?php echo e($titulo); ?></title>
<link rel="stylesheet" href="<?php echo asset('css/style.css'); ?>">
</head>
<body>

<nav class="navbar">
    <div class="nav-left">
        <div class="logo"><?php echo e($titulo); ?></div>

        <?php if(isset($_SESSION['usuario_id']) && $_SESSION['tipo_usuario'] == "prestador"): ?>
        <div class="botoes-left">
            <a href="<?php echo url('/vagas/criar'); ?>"><button>Criar serviço</button></a>
            <a href="<?php echo url('/vagas/minhas'); ?>"><button>Meus serviços</button></a>
        </div>
        <?php elseif(isset($_SESSION['usuario_id']) && $_SESSION['tipo_usuario'] == "buscador"): ?>
        <div class="botoes-left">
            <a href="<?php echo url('/candidaturas'); ?>"><button>Minhas candidaturas</button></a>
        </div>
        <?php endif; ?>
    </div>

    <div class="nav-right">
        <?php if(isset($_SESSION['usuario_id'])): ?>
        <div class="usuario-info">
            <b><?php echo e($_SESSION['email']); ?></b><br>
            <span><?php echo e($_SESSION['tipo_usuario']); ?></span>
        </div>

        <div class="botoes-right">
            <div class="dropdown">
                <button class="dropbtn" onclick="toggleMenu()">Perfil ▼</button>
                <div class="dropdown-content" id="perfilMenu">
                    <a href="<?php echo url('/perfil?id='); ?><?php echo (int) $_SESSION['usuario_id']; ?>">Meu perfil</a>
                    <?php if($_SESSION['tipo_usuario'] == "prestador"): ?>
                        <a href="<?php echo url('/perfil/editar'); ?>">Editar perfil</a>
                    <?php else: ?>
                        <a href="<?php echo url('/perfil/editar'); ?>">Editar perfil</a>
                    <?php endif; ?>
                    <a href="<?php echo url('/logout'); ?>" class="sair">Fazer Logout</a>
                </div>
            </div>
        </div>

        <?php else: ?>
        <div class="botoes-right">
            <a href="<?php echo url('/login'); ?>"><button>Login</button></a>
            <a href="<?php echo url('/cadastro'); ?>"><button>Cadastre-se</button></a>
        </div>
        <?php endif; ?>
    </div>
</nav>

<div class="container">
    <h1>Bem-vindo ao meu site</h1>
    <h2>Serviços disponíveis</h2>
    <p class="data">Hoje é <?php echo date("d/m/Y"); ?></p>

    <form method="GET" action="<?php echo url('/home'); ?>" class="search-box">
  <div class="search-container">
    <div class="input-wrapper">
      <input
        type="text"
        id="busca"
        name="busca"
        placeholder="Buscar serviços, categorias ou usuários"
        value="<?php echo e($busca); ?>"
        oninput="this.nextElementSibling.style.display = this.value ? 'block' : 'none';"
      >
      <button type="button" class="clear-btn" onclick="this.previousElementSibling.value=''; this.style.display='none';" style="display:<?php echo $busca ? 'block' : 'none'; ?>">✖</button>
    </div>
    <button type="submit" class="btn-buscar">Buscar</button>
  </div>
</form>

    <?php if(count($servicos) > 0): ?>
    <div class="servicos-grid">
        <?php foreach($servicos as $servico): ?>
        <div class="servico-card">
            <h3><?php echo e($servico['titulo']); ?></h3>
            <p><b>Categoria:</b> <?php echo e($servico['categoria']); ?></p>
            <p><b>Modalidade:</b> <?php echo e(modalidadeLabel($servico['modalidade'])); ?></p>
            <p><b>Preço:</b> <?php echo e($servico['preco']); ?></p>
            <p><b>Prestador / Empresa:</b> <?php echo e($servico['nome'] ?: $servico['email']); ?></p>

            <a href="<?php echo url('/vagas/detalhes?id='); ?><?php echo (int) $servico['id']; ?>">
                <button class="btn">Ver serviço</button>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <p>Nenhum serviço encontrado.</p>
    <?php endif; ?>
</div>

<script>
function toggleMenu(){
    let menu = document.getElementById('perfilMenu');
    menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
}

window.onclick = function(event){
    if(!event.target.matches('.dropbtn')){
        let menu = document.getElementById('perfilMenu');
        if(menu) menu.style.display = 'none';
    }
}
</script>
</body>
</html>

