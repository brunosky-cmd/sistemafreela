<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Candidaturas</title>
<link rel="stylesheet" href="<?php echo asset('css/candidaturas.css'); ?>">
</head>
<body>

<div class="container">

<h2>Candidaturas para este serviÃ§o</h2>

<?php if(count($candidaturas) > 0): ?>
    <?php foreach($candidaturas as $c): ?>

    <?php
        $status = strtolower(trim($c['status']));
        $status_class = "";
        if($status == "aguardando") $status_class = "status-aguardando";
        elseif($status == "aceito") $status_class = "status-aceito";
        elseif($status == "recusado") $status_class = "status-recusado";
    ?>

    <div class="candidatura-card">
        <p><b>Nome:</b> <?php echo e($c['nome']); ?></p>
        <p><b>Email:</b> <?php echo e($c['email']); ?></p>
        <p><b>Quem sou:</b> <?php echo e($c['quem_sou'] ?? '-'); ?></p>
        <p><b>Cidade:</b> <?php echo e($c['cidade'] ?? '-'); ?></p>
        <p><b>Valor por hora (R$):</b> <?php echo e($c['valor_hora'] ?? '-'); ?> | <b>SalÃ¡rio CLT (R$):</b> <?php echo e($c['salario'] ?? '-'); ?></p>
        <p class="candidatura-status <?php echo e($status_class); ?>">Status: <?php echo e(ucfirst($status)); ?></p>

        <div class="botoes-candidatura">
            <a href="<?php echo url('/candidaturas/aceitar?id='); ?><?php echo (int) $c['id']; ?>"><button class="btn-aceitar">Aceitar</button></a>
            <a href="<?php echo url('/candidaturas/cancelar?id='); ?><?php echo (int) $c['id']; ?>"><button class="btn-recusar">Recusar</button></a>
            <a href="<?php echo url('/perfil?id='); ?><?php echo (int) $c['buscador_id']; ?>"><button class="btn-perfil-candidato">Ver perfil</button></a>
        </div>
    </div>

    <?php endforeach; ?>
<?php else: ?>
    <p class="sem-candidaturas">Nenhuma candidatura ainda.</p>
<?php endif; ?>

<a href="<?php echo url('/vagas/minhas'); ?>"><button class="btn-voltar">Voltar a ServiÃ§os</button></a>

</div>
</body>
</html>

