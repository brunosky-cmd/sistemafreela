<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Perfil de <?php echo e($usuario['nome'] ?: $usuario['email']); ?></title>
<link rel="stylesheet" href="<?php echo asset('css/perfil.css'); ?>">
</head>
<body>

<div class="perfil-container">

<h2>Perfil de <?php echo e($usuario['nome'] ?: $usuario['email']); ?> (<?php echo e(ucfirst($usuario['tipo_usuario'])); ?>)</h2>

<p><b>Email:</b> <?php echo e($usuario['email']); ?></p>

<?php if($usuario['tipo_usuario'] == 'prestador'): ?>
    <p><b>Nome / Empresa:</b> <?php echo e($usuario['nome']); ?></p>
    <p><b>Categoria:</b> <?php echo e($perfil['categoria'] ?? ''); ?></p>
    <p><b>Telefone:</b> <?php echo e($perfil['telefone'] ?? ''); ?></p>
    <p><b>Cidade:</b> <?php echo e($perfil['cidade'] ?? ''); ?></p>
    <p><b>Bairro:</b> <?php echo e($perfil['bairro'] ?? ''); ?></p>
    <p><b>Rua:</b> <?php echo e($perfil['rua'] ?? ''); ?></p>
    <p><b>Sobre mim/nós:</b></p>
    <p class="perfil-sobre"><?php echo e($perfil['quem_sou'] ?? ''); ?></p>

<?php else: ?>
    <p><b>Nome / Empresa:</b> <?php echo e($usuario['nome']); ?></p>
    <p><b>Telefone:</b> <?php echo e($perfil['telefone'] ?? ''); ?></p>
    <p><b>CEP:</b> <?php echo e($perfil['cep'] ?? ''); ?></p>
    <p><b>Rua:</b> <?php echo e($perfil['rua'] ?? ''); ?></p>
    <p><b>Bairro:</b> <?php echo e($perfil['bairro'] ?? ''); ?></p>
    <p><b>Cidade:</b> <?php echo e($perfil['cidade'] ?? ''); ?></p>
    <p><b>Categoria:</b> <?php echo e($perfil['categoria'] ?? ''); ?></p>
    <p><b>Sobre mim:</b></p>
    <p class="perfil-sobre"><?php echo e($perfil['quem_sou'] ?? ''); ?></p>
    <p><b>Trabalho / Atividade:</b> <?php echo e($perfil['trabalho'] ?? ''); ?></p>
    <p><b>Valor por hora (R$):</b> <?php echo e($perfil['valor_hora'] ?? ''); ?></p>
    <p><b>Salário CLT (R$):</b> <?php echo e($perfil['salario'] ?? ''); ?></p>
<?php endif; ?>

<div class="perfil-botoes">
<?php if($usuario_id_logado == $id): ?>
    <?php if($tipo_usuario_logado == 'prestador'): ?>
        <a href="<?php echo url('/perfil/editar'); ?>"><button>Editar perfil</button></a>
        <a href="<?php echo url('/vagas/minhas'); ?>"><button>Meus serviços</button></a>
    <?php else: ?>
        <a href="<?php echo url('/perfil/editar'); ?>"><button>Editar perfil</button></a>
        <a href="<?php echo url('/candidaturas'); ?>"><button>Minhas Candidaturas</button></a>
    <?php endif; ?>
    <a href="<?php echo url('/perfil/excluir'); ?>" onclick="return confirm('Tem certeza que deseja excluir seu perfil? Esta ação não pode ser desfeita.')">
        <button class="btn-excluir">Excluir perfil</button>
    </a>

<?php endif; ?>

<a href="<?php echo url('/home'); ?>"><button class="btn-voltar">Voltar ao início</button></a>
</div>

</div>
</body>
</html>

