<?php
session_start();

// verifica se o indice usuário da variavel session existe, ou seja, se o usuário foi autenticado, isso evita que a página seja acessada sem um login (autenticação)
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php?erro=1');
}
require_once 'db.class.php';

// pega o ID da URL
$id_usuario = $_SESSION['id_usuario'];
// valida o ID
if (empty($id_usuario))
{
    echo "ID para alteração não definido";
    exit;
}
// atribuindo uma instância da classe db
$objDb = new db();
// variavel recebe o retorno da função de conexão
$link = $objDb->conecta_mysql();
// verifica se o usuário já existe
$sql = "select usuario, email, senha from usuarios where id = '$id_usuario' ";

$resultado_id = mysqli_query($link, $sql);
$dados_usuario = mysqli_fetch_array($resultado_id);
// executar a query ( mysqli_query(o link de conexão com o bd, a query em si) );
?>
<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">

		<title>Twitter clone</title>

		<!-- jquery - link cdn -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

	</head>

	<body>

		<!-- Static navbar -->
	    <nav class="navbar navbar-default navbar-static-top">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <img src="imagens/icone_twitter.png" />
	        </div>

	        <div id="navbar" class="navbar-collapse collapse">
	          <ul class="nav navbar-nav navbar-right">
	            <li><a href="home.php">Voltar para Home</a></li>
				<!-- botão que irá encerrar a sessão -->
				<li><a href="sair.php">Sair</a></li>
				<li><a  class="text-uppercase" ><?=$_SESSION['usuario']?></a></li>

	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav>


	    <div class="container">

	    	<br /><br />

	    	<div class="col-md-4"></div>
			
	    	<div class="col-md-4">
	    		<h3>Editando ....</h3>
	    		<br />
	    		<!-- os dados do form serão enviados para edit_conta.php com o método post -->
				<form method="post" action="edit_conta.php" id="formCadastrarse">
					<div class="form-group">
						<input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuário" required="requiored"> <br><?php echo $dados_usuario['usuario'] ?>
						<!-- e então verifica se o usuário digitado no campo já existe -->
					</div>

					<div class="form-group">  
						<input type="email" class="form-control" id="email" name="email" placeholder="Email" required="requiored"><br><?php echo $dados_usuario['email'] ?>
						<!-- o msm para o email digitado -->
					</div>

					<div class="form-group">
						
						<input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" ><br> 
						<input type="hidden" name="senha" value="<?php echo $dados_usuario['senha'] ?>">             
					</div>
                    <input type="hidden" name="id" value="<?php echo $id_usuario ?>">

					<button type="submit" class="btn btn-primary form-control">Editar</button> <br><br>

				</form>
			</div>
			<div class="col-md-4"></div>

			<div class="clearfix"></div>
			<br />
			<div class="col-md-4"></div>
			<div class="col-md-4"></div>
			<div class="col-md-4"></div>

		</div>


	    </div>

		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

	</body>
</html>