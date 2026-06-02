<?php
session_start();

if(!isset($_SESSION['usuario_id'])){
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost","root","","sistema_servicos");

$usuario_id = $_SESSION['usuario_id'];

// Busca todos os serviços do prestador
$sql = "SELECT * FROM servicos WHERE usuario_id='$usuario_id' ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
<meta charset="UTF-8">
<title>Meus Serviços</title>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/meus_servicos.css">
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar">
<div class="nav-left">
    <div class="logo">Meu Site em PHP</div>
    <div class="botoes-left">
        <a href="index.php"><button>Voltar ao início</button></a>
        <a href="criar_servico.php"><button class="btn-criar-servico">Criar Serviço</button></a>
    </div>
</div>

<div class="nav-right">
<?php if(isset($_SESSION['usuario_id'])): ?>
    <div class="usuario-info">
        <b><?php echo $_SESSION['email']; ?></b><br>
        <span><?php echo $_SESSION['tipo_usuario']; ?></span>
    </div>

    <div class="botoes-right">
        <div class="dropdown">
            <button class="dropbtn" onclick="toggleMenu()">Perfil ▼</button>
            <div class="dropdown-content" id="perfilMenu">
                <a href="perfil.php?id=<?php echo $_SESSION['usuario_id']; ?>">Meu perfil</a>
                <a href="editar_prestador.php">Editar perfil</a>
            </div>
        </div>
        <a href="logout.php"><button>Sair</button></a>
    </div>
<?php endif; ?>
</div>
</nav>

<div class="container">
<h1>Meus Serviços</h1>

<?php if($result->num_rows > 0): ?>
<div class="servicos-grid">

<?php while($row = $result->fetch_assoc()): ?>
<div class="servico-card">
    <h3><?php echo $row['titulo']; ?></h3>

    <p><strong>Categoria:</strong> <?php echo $row['categoria']; ?></p>
    <p><strong>Modalidade:</strong> <?php echo $row['modalidade']; ?></p>
    <p><strong>Preço:</strong> <?php echo $row['preco']; ?></p>
    <p><strong>Cidade/UF:</strong> <?php echo $row['cidade'] . " / " . $row['uf']; ?></p>
    <p><?php echo $row['descricao']; ?></p>

    <div class="botoes-card">
        <a href="editar_servico.php?id=<?php echo $row['id']; ?>">
            <button class="ms-btn">Editar</button>
        </a>
        <a href="excluir_servico.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este serviço?');">
            <button class="ms-btn-excluir">Excluir</button>
        </a>
        <a href="candidaturas.php?servico_id=<?php echo $row['id']; ?>">
            <button class="btn-candidaturas">Ver candidaturas</button>
        </a>
    </div>
</div>
<?php endwhile; ?>

</div>
<?php else: ?>
<p class="sem-servicos">Nenhum serviço cadastrado ainda.</p>
<?php endif; ?>

</div>

<script src="js/script.js"></script>
</body>
</html>