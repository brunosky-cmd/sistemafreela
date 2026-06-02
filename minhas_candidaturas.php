<?php
session_start();

if(!isset($_SESSION['usuario_id'])){
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost","root","","sistema_servicos");

$buscador_id = $_SESSION['usuario_id'];

// Busca candidaturas com dados do prestador e do serviço
$sql = "SELECT 
        candidaturas.status,
        servicos.id as servico_id,
        servicos.titulo,
        servicos.cidade,
        servicos.uf,
        servicos.modalidade,
        usuarios.nome as prestador_nome,
        usuarios.id as prestador_id
    FROM candidaturas
    JOIN servicos ON candidaturas.servico_id = servicos.id
    JOIN usuarios ON servicos.usuario_id = usuarios.id
    WHERE candidaturas.buscador_id = '$buscador_id'
    ORDER BY candidaturas.id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Minhas Candidaturas</title>
<link rel="stylesheet" href="css/minhas_candidaturas.css">
</head>
<body>

<div class="container">
<h2>Minhas Candidaturas</h2>

<?php if($result->num_rows > 0): ?>
    <div class="candidaturas-grid">
    <?php while($row = $result->fetch_assoc()): ?>

        <?php
        $status = strtolower(trim($row['status']));
        $status_class = "";
        if($status == "aguardando") $status_class = "status-aguardando";
        elseif($status == "aceito") $status_class = "status-aceito";
        elseif($status == "recusado") $status_class = "status-recusado";
        ?>

        <div class="card-candidatura">
            <h3><?php echo htmlspecialchars($row['titulo']); ?></h3>
            <p><b>Prestador / Empresa:</b> <?php echo htmlspecialchars($row['prestador_nome']); ?></p>
            <p><b>Cidade / UF:</b> <?php echo htmlspecialchars($row['cidade']); ?> / <?php echo htmlspecialchars($row['uf']); ?></p>
            <p><b>Modalidade:</b> <?php echo htmlspecialchars($row['modalidade']); ?></p>
            <p class="status <?php echo $status_class; ?>">Status: <?php echo ucfirst($status); ?></p>

            <div class="card-botoes-candidatura">
                <?php if($status == "aceito"): ?>
                    <a href="perfil.php?id=<?php echo $row['prestador_id']; ?>">
                        <button class="btn-perfil-candidatura">Ver perfil do prestador</button>
                    </a>
                <?php endif; ?>
                    <a href="servico.php?id=<?php echo $row['servico_id']; ?>">
                        <button class="btn-ver-servico-candidatura">Ver detalhes da vaga</button>
                    </a>
            </div>
        </div>

    <?php endwhile; ?>
    </div>
<?php else: ?>
    <p class="sem-vagas">Você ainda não se candidatou a nenhuma vaga.</p>
<?php endif; ?>

<a href="index.php">
    <button class="btn-voltar-candidatura">Voltar ao início</button>
</a>
</div>

</body>
</html>