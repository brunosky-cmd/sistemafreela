<?php

$mensagem = "";
$sucesso = false;

if($_SERVER["REQUEST_METHOD"] == "POST"){

$host = "localhost";
$user = "root";
$pass = "";
$db = "sistema_servicos";

$conn = new mysqli($host,$user,$pass,$db);

if($conn->connect_error){
die("Erro: ".$conn->connect_error);
}

$email = $_POST['email'];
$senha = $_POST['senha'];
$tipo = $_POST['tipo_usuario'];
$telefone = $_POST['telefone'];
$cep = $_POST['cep'];
$trabalho = $_POST['trabalho'];

$sql = "INSERT INTO usuarios (email,senha,tipo_usuario)
VALUES ('$email','$senha','$tipo')";

if($conn->query($sql)){

$usuario_id = $conn->insert_id;

if($tipo == "buscador"){

$sql2 = "INSERT INTO perfil_buscador
(usuario_id,cep,telefone,trabalho)
VALUES
('$usuario_id','$cep','$telefone','$trabalho')";

$conn->query($sql2);

}else{

$sql2 = "INSERT INTO perfil_prestador
(usuario_id,trabalho)
VALUES
('$usuario_id','$trabalho')";

$conn->query($sql2);

}

$mensagem = "Conta criada com sucesso! Seus dados foram registrados no banco de dados.";
$sucesso = true;

}else{
$mensagem = "Erro ao cadastrar.";
}

$conn->close();

}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Cadastro</title>
<link rel="stylesheet" href="css/cadastrostyle.css">
</head>

<body>

<div class="cadastro-box">

<h2>Criar conta</h2>

<?php if($mensagem != ""): ?>

<p class="<?php echo $sucesso ? 'sucesso' : 'erro'; ?>">
<?php echo $mensagem; ?>
</p>

<?php if($sucesso): ?>

<a href="login.php">
<button class="btn">Fazer login</button>
</a>

<?php endif; ?>

<br><br>

<?php endif; ?>


<?php if(!$sucesso): ?>

<form method="POST">

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="senha" placeholder="Senha" required>

<select name="tipo_usuario" required>
<option value="">Selecione o tipo de usuário</option>
<option value="buscador">Buscador de serviço</option>
<option value="prestador">Prestador de serviço</option>
</select>

<input type="text" name="telefone" placeholder="Telefone" required>

<input type="text" name="cep" placeholder="CEP" required>

<input type="text" name="trabalho" placeholder="Profissão / Serviço" required>

<button type="submit" class="btn">Cadastrar</button>

</form>

<?php endif; ?>

<br>

<a href="index.php">
<button class="btn-voltar">Voltar ao início</button>
</a>

</div>

</body>
</html>