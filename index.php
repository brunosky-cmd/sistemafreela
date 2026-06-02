<?php
session_start();
$titulo = "Meu Site em PHP";

/* CONEXÃO COM BANCO */
$conn = new mysqli("localhost","root","","sistema_servicos");
if($conn->connect_error){
    die("Erro de conexão: " . $conn->connect_error);
}

/* BUSCA */
$busca = "";
if(isset($_GET['busca']) && $_GET['busca'] != ""){
    $busca = $conn->real_escape_string($_GET['busca']);
    $sql = "SELECT servicos.*, usuarios.email, usuarios.nome
            FROM servicos
            JOIN usuarios ON servicos.usuario_id = usuarios.id
            WHERE servicos.titulo LIKE '%$busca%' OR servicos.categoria LIKE '%$busca%' OR usuarios.email LIKE '%$busca%'
            ORDER BY servicos.data_criacao DESC";
}else{
    $sql = "SELECT servicos.*, usuarios.email, usuarios.nome
            FROM servicos
            JOIN usuarios ON servicos.usuario_id = usuarios.id
            ORDER BY servicos.data_criacao DESC";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title><?php echo $titulo; ?></title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="nav-left">
        <div class="logo"><?php echo $titulo; ?></div>

        <?php if(isset($_SESSION['usuario_id']) && $_SESSION['tipo_usuario'] == "prestador"): ?>
        <div class="botoes-left">
            <a href="criar_servico.php"><button>Criar serviço</button></a>
            <a href="meus_servicos.php"><button>Meus serviços</button></a>
        </div>
        <?php elseif(isset($_SESSION['usuario_id']) && $_SESSION['tipo_usuario'] == "buscador"): ?>
        <div class="botoes-left">
            <a href="minhas_candidaturas.php"><button>Minhas candidaturas</button></a>
        </div>
        <?php endif; ?>
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
                    <?php if($_SESSION['tipo_usuario'] == "prestador"): ?>
                        <a href="editar_prestador.php">Editar perfil</a>
                    <?php else: ?>
                        <a href="editar_buscador.php">Editar perfil</a>
                    <?php endif; ?>
                    <a href="logout.php" class="sair">Fazer Logout</a>
                </div>
            </div>
        </div>

        <?php else: ?>
        <div class="botoes-right">
            <a href="login.php"><button>Login</button></a>
            <a href="cadastro.php"><button>Cadastre-se</button></a>
        </div>
        <?php endif; ?>
    </div>
</nav>

<!-- CONTEÚDO -->
<div class="container">
    <h1>Bem-vindo ao meu site</h1>
    <h2>Serviços disponíveis</h2>
    <p class="data">Hoje é <?php echo date("d/m/Y"); ?></p>

    <!-- BUSCADOR -->
    <form method="GET" action="index.php" class="search-box">
  <div class="search-container">
    <div class="input-wrapper">
      <input 
        type="text" 
        id="busca" 
        name="busca" 
        placeholder="Buscar serviços, categorias ou usuários" 
        value="<?php echo $busca; ?>"
        oninput="this.nextElementSibling.style.display = this.value ? 'block' : 'none';"
      >
      <button type="button" class="clear-btn" onclick="this.previousElementSibling.value=''; this.style.display='none';" style="display:<?php echo $busca ? 'block' : 'none'; ?>">✖</button>
    </div>
    <button type="submit" class="btn-buscar">Buscar</button>
  </div>
</form>

    <!-- CARDS DE SERVIÇOS -->
    <?php if($result && $result->num_rows > 0): ?>
    <div class="servicos-grid">
        <?php while($servico = $result->fetch_assoc()): ?>
        <div class="servico-card">
            <h3><?php echo htmlspecialchars($servico['titulo']); ?></h3>
            <p><b>Categoria:</b> <?php echo htmlspecialchars($servico['categoria']); ?></p>
            <p><b>Modalidade:</b> <?php echo htmlspecialchars($servico['modalidade']); ?></p>
            <p><b>Preço:</b> <?php echo htmlspecialchars($servico['preco']); ?></p>
            <p><b>Prestador / Empresa:</b> <?php echo htmlspecialchars($servico['nome'] ?: $servico['email']); ?></p>

            <a href="servico.php?id=<?php echo $servico['id']; ?>">
                <button class="btn">Ver serviço</button>
            </a>
        </div>
        <?php endwhile; ?>
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

// Fechar menu clicando fora
window.onclick = function(event){
    if(!event.target.matches('.dropbtn')){
        let menu = document.getElementById('perfilMenu');
        if(menu) menu.style.display = 'none';
    }
}
</script>
</body>
</html>