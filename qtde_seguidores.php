<?php
session_start();

// verifica se o indice usuário da variavel session existe, ou seja, se o usuário foi autenticado, isso evita que a página seja acessada sem um login (autenticação)
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php?erro=1');
}

require_once 'db.class.php';

$objDb = new db();
$link  = $objDb->conecta_mysql();

$id_usuario = $_SESSION['id_usuario'];

// exibir qtde de seguidores

// é necessário recuperar a quantidade de seguidores e isso eh feito com o COUNT()
$sql = " SELECT COUNT(*) AS qtde_seguidores FROM usuarios_seguidores WHERE id_usuario = $id_usuario ";


$resultado_id = mysqli_query($link, $sql);
$qtde_seguidores = 0;


if ($resultado_id) {
    $registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);

    // é atribuido à variavel o indice de $registro que corresponde ao alias da query
    $qtde_seguidores = $registro['qtde_seguidores'];

    // exibe na div $qtde_seguidores
    echo "<a href=seguidores.php> SEGUIDORES </a> <br>$qtde_seguidores";

} else {
    echo "Erro ao executar a query";
}


?>