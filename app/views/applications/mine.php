<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Minhas Candidaturas</title>
<link rel="stylesheet" href="<?php echo asset('css/minhas_candidaturas.css'); ?>">
</head>
<body>

<div class="container">
<h2>Minhas Candidaturas</h2>

<?php if(count($candidaturas) > 0): ?>
    <div class="candidaturas-grid">
    <?php foreach($candidaturas as $row): ?>

        <?php
        $status = strtolower(trim($row['status']));
        $status_class = "";
        if($status == "aguardando") $status_class = "status-aguardando";
        elseif($status == "aceito") $status_class = "status-aceito";
        elseif($status == "recusado") $status_class = "status-recusado";
        ?>

        <div class="card-candidatura">
            <h3><?php echo e($row['titulo']); ?></h3>
            <p><b>Prestador / Empresa:</b> <?php echo e($row['prestador_nome']); ?></p>
            <p><b>Cidade / UF:</b> <?php echo e($row['cidade']); ?> / <?php echo e($row['uf']); ?></p>
            <p><b>Modalidade:</b> <?php echo e(modalidadeLabel($row['modalidade'])); ?></p>
            <p class="status <?php echo e($status_class); ?>">Status: <?php echo e(ucfirst($status)); ?></p>

            <div class="card-botoes-candidatura">
                <?php if($status == "aceito"): ?>
                    <a href="<?php echo url('/perfil?id='); ?><?php echo (int) $row['prestador_id']; ?>">
                        <button class="btn-perfil-candidatura">Ver perfil do prestador</button>
                    </a>
                <?php endif; ?>
                    <a href="<?php echo url('/vagas/detalhes?id='); ?><?php echo (int) $row['servico_id']; ?>">
                        <button class="btn-ver-servico-candidatura">Ver detalhes da vaga</button>
                    </a>
            </div>
        </div>

    <?php endforeach; ?>
    </div>
<?php else: ?>
    <p class="sem-vagas">Você ainda não se candidatou a nenhuma vaga.</p>
<?php endif; ?>

<a href="<?php echo url('/home'); ?>">
    <button class="btn-voltar-candidatura">Voltar ao início</button>
</a>
</div>

</body>
</html>

