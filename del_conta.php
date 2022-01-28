<?php

// para que possamos recuperar os dados de session
session_start();

// verificação de controle
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php?erro=1');
}

require_once 'db.class.php';

// recuperando o id do usuário da sessão (logado)
$id_usuario = $_SESSION['id_usuario'];

$objDb = new db();
$link  = $objDb->conecta_mysql();

// preparando a query de insert do registro na tabela usuarios_seguidores

$sql = " SET SQL_SAFE_UPDATES = 0";
$sql1 = " DELETE FROM usuarios WHERE id = $id_usuario ";
$sql2 = " DELETE FROM usuarios_seguidores WHERE id_usuario = $id_usuario ";
$sql3 = " DELETE FROM usuarios_seguidores WHERE seguindo_id_usuario = $id_usuario ";
$sql4 = " DELETE FROM tweet WHERE id_usuario = $id_usuario ";

// por fim, executamos a query
mysqli_query($link, $sql);
mysqli_query($link, $sql1);
mysqli_query($link, $sql2);
mysqli_query($link, $sql3);
mysqli_query($link, $sql4);


unset($_SESSION['usuario']);
unset($_SESSION['email']);

 
// retorna para a index.php
header('Location:index.php?logoff=1');
session_destroy();
?>