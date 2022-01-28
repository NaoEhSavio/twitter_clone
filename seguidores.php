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

$sql = " SELECT COUNT(*) AS qtde_seguidores FROM usuarios_seguidores WHERE id_usuario = $id_usuario ";

$resultado_id = mysqli_query($link, $sql);

$qtde_seguidores = 0;

if ($resultado_id) {
    $registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);

    // é atribuido à variavel o indice de $registro que corresponde ao alias da query
    $qtde_seguidores = $registro['qtde_seguidores'];
} else {
    echo "Erro ao executar a query";
}

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

		<!-- código javascript -->
		<script type="text/javascript">
					$(document).ready( function(){
				function atualizaseguidores(){
					//carregar os seguidores
					$.ajax({
						url: 'get_seguidores.php',
						success: function(data) {
							$('#seguidores').html(data);
							// botões Seguir
							$('.btn_seguir').click( function(){
									// com o 'data' podemos recuperar os dados do atributo customizado que definimos no botão em get_seguidores.php
									var id_usuario = $(this).data('id_usuario');
									// caso o botão de seguir seja clicado, o mesmo será ocultado e o botão deixar de seguir será exibido no lugar dele
									$('#btn_seguir_'+id_usuario).hide();
									$('#btn_deixar_seguir_'+id_usuario).show();
									//alert(id_usuario);
									$.ajax({
										url: 'seguir.php',
										method: 'post',
										// será enviado o id do usuário recuperado do botão através de um JSON ({})
										data: { seguir_id_usuario: id_usuario },
										success: function(data){
											alert('Registro efetuado com sucesso!');
										}
									});

								});
								// botões Deixar de Seguir
								$('.btn_deixar_seguir').click( function(){
									// funciona q forma que no botão seguir 
									var id_usuario = $(this).data('id_usuario');
									// caso o botão deixar de deixar de seguir seja clicado, o mesmo será ocultado e o botão de seguir será exibido no lugar dele
									$('#btn_seguir_'+id_usuario).show();
									$('#btn_deixar_seguir_'+id_usuario).hide();
									//alert(id_usuario);
									$.ajax({
										url: 'deixar_seguir.php',
										method: 'post',
										// será enviado o id do usuário recuperado do botão através de um JSON ({})
										data: { deixar_seguir_id_usuario: id_usuario },
										success: function(data){
											alert('Registro removido com sucesso!');
										}
									});

								});

						}
						
					});
				}
				
					$('.btn_del_conta').click( function(){

						// recuperando o valor do atributo customizado
						var id_usuario = $(this).data('id_usuario');

							// enviando para del_conta.php via requisição
						$.ajax({
							url: 'del_conta.php',
							method: 'post',

								// será enviado o id do tweet recuperado do botão através de um JSON ({})
							data: { id_usuario: id_usuario },
								success: function(data){
									alert('Conta removida com sucesso !');
									}
						});

			         });
				
					// atualiza qtde tweets
					function atualizaQtdeTweet() {
					$.ajax({
						url: 'qtde_tweets.php',
						success: function(data) {
							$('#qtde_tweets').html(data);
						}
					})	
				}
					function atualizaQtdeseguidores() {

					$.ajax({

						url: 'qtde_seguidores.php',
						success: function(data) {
							$('#qtde_seguidores').html(data);
						}
					})
				}
				// executa a função
				atualizaQtdeseguidores();
				atualizaQtdeTweet();
				atualizaseguidores();	
			});
		</script>

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
					<!-- botão que para relogar a pagina -->
	            	<li><a href="home.php">Home</a></li>
	            	<!-- botão que irá encerrar a sessão -->
	            	<li><a href="sair.php">Sair</a></li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav>


	    <div class="container">

	    	<!-- barras laterais e timeline com bootstrap -->

	    	<div class="col-md-3">
	    		<!-- barra da esquerda -->
	    		<div class="panel panel-default">
	    			<div class="panel-body">
						<button type="button" class="btn btn-default btn-xs btn_del_conta pull-right" data-id_usuario=""><a href="#">Excluir</a> </button>
						<button type="button" class="btn btn-default btn-xs btn_edt_conta pull-right"><a href="editar_usuario.php">Editar</a> </button>
	    				<!-- será exibido o nome do usuário -->
	    				<h4 class="text-uppercase" ><?=$_SESSION['usuario']?></h4>
	    				<hr>
	    				<div class="col-md-6" id="qtde_tweets"> <?= $qtde_tweets ?>
	    				</div>
	    				<div class="col-md-6" id="qtde_seguidores">  <?=$qtde_seguidores?>
	    				</div>
	    			</div>
	    		</div>
	    	</div>
	    	<!-- painel central (onde fica timeline) -->
	    	<div class="col-md-6">
	    		<div class="panel panel-default">
	    			<div class="panel-body">
	    				
	    			</div>
	    		</div>

	    		<!-- div que conterá a lista de exibição de usuários de acordo com a pesquisa -->

				<div id="seguidores" class="list-group"></div>

			</div>
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-body">
						<h4><a href="procurar_pessoas.php">Procurar por pessoas</h4>
					</div>
				</div>
			</div>
		</div>


	    </div>

		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

	</body>
</html>