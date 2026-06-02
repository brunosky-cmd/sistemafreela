<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title><?php echo e($servico['titulo']); ?></title>
<link rel="stylesheet" href="<?php echo asset('css/servico.css'); ?>">
</head>
<body>

<div class="servico-container">

<div class="servico-card">

<h1><?php echo e($servico['titulo']); ?></h1>

<p><b>Categoria:</b> <?php echo e($servico['categoria']); ?></p>
<p><b>Modalidade:</b> <?php echo e(modalidadeLabel($servico['modalidade'])); ?></p>
<p><b>PreÃ§o:</b> <?php echo e($servico['preco']); ?></p>
<p><b>Cidade:</b> <?php echo e($servico['cidade']); ?> / <?php echo e($servico['uf']); ?></p>
<p><b>Prestador / Empresa:</b> <?php echo e($servico['nome'] ?: $servico['email']); ?></p>

<p><b>DescriÃ§Ã£o:</b></p>
<p class="servico-descricao"><?php echo e($servico['descricao']); ?></p>

<div class="servico-botoes">

<?php if(!isset($_SESSION['usuario_id'])): ?>
    <p style="color: #facc15; font-weight:bold;">FaÃ§a login para se candidatar a esta vaga.</p>
<?php elseif($_SESSION['tipo_usuario']=="buscador"): ?>

    <?php if($candidatura_status == ""): ?>
        <a href="<?php echo url('/candidaturas/criar?servico_id='); ?><?php echo (int) $servico['id']; ?>">
            <button>Candidatar-se</button>
        </a>
    <?php elseif($candidatura_status == "aguardando"): ?>
        <p>Aguardando resposta do prestador</p>
    <?php elseif($candidatura_status == "recusado"): ?>
        <p>Candidatura recusada</p>
    <?php elseif($candidatura_status == "aceito"): ?>
        <a href="<?php echo url('/perfil?id='); ?><?php echo (int) $servico['usuario_id']; ?>">
            <button>Ver perfil do prestador</button>
        </a>
    <?php endif; ?>

<?php endif; ?>

<a href="<?php echo url('/home'); ?>">
    <button>Voltar</button>
</a>

</div>
</div>
</div>

</body>
</html>

