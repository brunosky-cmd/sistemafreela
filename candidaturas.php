<?php
session_start();

if(!isset($_SESSION['usuario_id'])){
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost","root","","sistema_servicos");

$usuario_id = $_SESSION['usuario_id'];
$servico_id = $_GET['servico_id'] ?? 0;

/* Verificar se o serviço é do usuário */
$sql_servico = "SELECT * FROM servicos WHERE id='$servico_id' AND usuario_id='$usuario_id'";
$result_servico = $conn->query($sql_servico);

if(!$result_servico || $result_servico->num_rows == 0){
    die("Você não tem permissão para ver essas candidaturas.");
}

/* Buscar candidaturas com dados do buscador */
$sql = "SELECT c.id, c.status, u.id as buscador_id, u.nome, u.email,
               p.quem_sou, p.cidade, p.valor_hora, p.salario
        FROM candidaturas c
        JOIN usuarios u ON c.buscador_id = u.id
        LEFT JOIN perfil_buscador p ON p.usuario_id = u.id
        WHERE c.servico_id='$servico_id'
        ORDER BY c.data_candidatura DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Candidaturas</title>
<link rel="stylesheet" href="css/candidaturas.css">
</head>
<body>

<div class="container">

<h2>Candidaturas para este serviço</h2>

<?php if($result && $result->num_rows > 0): ?>
    <?php while($c = $result->fetch_assoc()): ?>

    <?php
        $status = strtolower(trim($c['status']));
        $status_class = "";
        if($status == "aguardando") $status_class = "status-aguardando";
        elseif($status == "aceito") $status_class = "status-aceito";
        elseif($status == "recusado") $status_class = "status-recusado";
    ?>

    <div class="candidatura-card">
        <p><b>Nome:</b> <?php echo htmlspecialchars($c['nome']); ?></p>
        <p><b>Email:</b> <?php echo htmlspecialchars($c['email']); ?></p>
        <p><b>Quem sou:</b> <?php echo htmlspecialchars($c['quem_sou']) ?? '-'; ?></p>
        <p><b>Cidade:</b> <?php echo htmlspecialchars($c['cidade']) ?? '-'; ?></p>
        <p><b>Valor por hora (R$):</b> <?php echo $c['valor_hora'] ?? '-'; ?> | <b>Salário CLT (R$):</b> <?php echo $c['salario'] ?? '-'; ?></p>
        <p class="candidatura-status <?php echo $status_class; ?>">Status: <?php echo ucfirst($status); ?></p>

        <div class="botoes-candidatura">
            <a href="aceitar.php?id=<?php echo $c['id']; ?>"><button class="btn-aceitar">Aceitar</button></a>
            <a href="recusar.php?id=<?php echo $c['id']; ?>"><button class="btn-recusar">Recusar</button></a>
            <a href="perfil.php?id=<?php echo $c['buscador_id']; ?>"><button class="btn-perfil-candidato">Ver perfil</button></a>
        </div>
    </div>

    <?php endwhile; ?>
<?php else: ?>
    <p class="sem-candidaturas">Nenhuma candidatura ainda.</p>
<?php endif; ?>

<a href="meus_servicos.php"><button class="btn-voltar">Voltar a Serviços</button></a>

</div>
</body>
</html>