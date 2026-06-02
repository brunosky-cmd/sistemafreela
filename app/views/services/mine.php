<!DOCTYPE html>
<html lang="pt-br">

<head>
<meta charset="UTF-8">
<title>Meus ServiÃ§os</title>
<link rel="stylesheet" href="<?php echo asset('css/style.css'); ?>">
<link rel="stylesheet" href="<?php echo asset('css/meus_servicos.css'); ?>">
</head>

<body>

<nav class="navbar">
<div class="nav-left">
    <div class="logo">Meu Site em PHP</div>
    <div class="botoes-left">
        <a href="<?php echo url('/home'); ?>"><button>Voltar ao inÃ­cio</button></a>
        <a href="<?php echo url('/vagas/criar'); ?>"><button class="btn-criar-servico">Criar ServiÃ§o</button></a>
    </div>
</div>

<div class="nav-right">
<?php if(isset($_SESSION['usuario_id'])): ?>
    <div class="usuario-info">
        <b><?php echo e($_SESSION['email']); ?></b><br>
        <span><?php echo e($_SESSION['tipo_usuario']); ?></span>
    </div>

    <div class="botoes-right">
        <div class="dropdown">
            <button class="dropbtn" onclick="toggleMenu()">Perfil â–¼</button>
            <div class="dropdown-content" id="perfilMenu">
                <a href="<?php echo url('/perfil?id='); ?><?php echo (int) $_SESSION['usuario_id']; ?>">Meu perfil</a>
                <a href="<?php echo url('/perfil/editar'); ?>">Editar perfil</a>
            </div>
        </div>
        <a href="<?php echo url('/logout'); ?>"><button>Sair</button></a>
    </div>
<?php endif; ?>
</div>
</nav>

<div class="container">
<h1>Meus ServiÃ§os</h1>

<?php if(count($servicos) > 0): ?>
<div class="servicos-grid">

<?php foreach($servicos as $row): ?>
<div class="servico-card">
    <h3><?php echo e($row['titulo']); ?></h3>

    <p><strong>Categoria:</strong> <?php echo e($row['categoria']); ?></p>
    <p><strong>Modalidade:</strong> <?php echo e(modalidadeLabel($row['modalidade'])); ?></p>
    <p><strong>PreÃ§o:</strong> <?php echo e($row['preco']); ?></p>
    <p><strong>Cidade/UF:</strong> <?php echo e(($row['cidade'] ?? '') . " / " . ($row['uf'] ?? '')); ?></p>
    <p><?php echo e($row['descricao']); ?></p>

    <div class="botoes-card">
        <a href="<?php echo url('/vagas/editar?id='); ?><?php echo (int) $row['id']; ?>">
            <button class="ms-btn">Editar</button>
        </a>
        <a href="<?php echo url('/vagas/excluir?id='); ?><?php echo (int) $row['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este serviÃ§o?');">
            <button class="ms-btn-excluir">Excluir</button>
        </a>
        <a href="<?php echo url('/candidaturas?servico_id='); ?><?php echo (int) $row['id']; ?>">
            <button class="btn-candidaturas">Ver candidaturas</button>
        </a>
    </div>
</div>
<?php endforeach; ?>

</div>
<?php else: ?>
<p class="sem-servicos">Nenhum serviÃ§o cadastrado ainda.</p>
<?php endif; ?>

</div>

<script src="<?php echo asset('js/script.js'); ?>"></script>
</body>
</html>

