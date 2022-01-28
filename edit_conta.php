
<?php
// importando a classe de conexão com o MySQL
require_once 'db.class.php';

// recuperando os dados do formulário de cadastro
$usuario = $_POST['usuario'];
$email   = $_POST['email'];

// será feita a criptografia MD5 da senha, converte em um hash de 32 caracteres que não poderam ser descriptografados (mão única)
$senha = ($_POST['senha']);

// atribuindo uma instância da classe db
$objDb = new db();

// variavel recebe o retorno da função de conexão
$link = $objDb->conecta_mysql();
 
// resgata os valores do formulário
$usuario = isset($_POST['usuario']) ? $_POST['usuario'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$senha = isset($_POST['senha']) ? $_POST['senha'] : null;
$id_usuario = isset($_POST['id']) ? $_POST['id'] : null;
 
// validação (bem simples, mais uma vez)
if (empty($usuario) || empty($email) || empty($senha))
{
    echo "Volte e preencha todos os campos";
    exit;
}
 
 
// atualiza o banco
$sql = "UPDATE usuarios SET usuario = '$usuario', email = '$email', senha = '$senha' WHERE id = '$id_usuario'";
if (mysqli_query($link, $sql)) {
    //
    header('Location: index.php?success=1');

    echo "Usuário Editado com sucesso !";
} else {
    echo "Erro ao editar o usuário !";
}
?>