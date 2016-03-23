<?php
ob_start();
session_start();
if(isset($_SESSION['usuarioj']) && (isset($_SESSION['senhaj']))){
	header("location:home.php");exit;
}
include("conexao/conecta.php");

?>
<!DOCTYPE html>
<html lang="pt-br">
  
<head>
    <meta charset="utf-8">
    <title>Jeyziel - login</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes"> 
    
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />

<link href="css/font-awesome.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/pages/signin.css" rel="stylesheet" type="text/css">

</head>

<body>
	
	<div class="navbar navbar-fixed-top">
	
	<div class="navbar-inner">
		
		<div class="container">
			
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			
			<a class="brand" href="home.php">
				jeyziel login
			</a>		
			
			<div class="nav-collapse">
				<ul class="nav pull-right">
					
					<li class="">						
						<a href="lembrar.php" class="">
							Esqueceu sua senha?
						</a>
						
					</li>
					
					<li class="">						
						<a href="../" class="">
							<i class="icon-chevron-left"></i>
							Acessar o site
						</a>
						
					</li>
				</ul>
				
			</div><!--/.nav-collapse -->	
	
		</div> <!-- /container -->
		
	</div> <!-- /navbar-inner -->
	
</div> <!-- /navbar -->
<?php
	//negar acao quando digitarem /home.php sem fazer o login cc header.php
	if(isset($_GET['acao'])){
		if(!isset($_POST['logar'])){
			$acao = $_GET['acao'];
			if($acao=='negado'){
				echo '<div class="alert alert-danger">
						  <button type="button" class="close" data-dismiss="alert">×</button>
						  <strong>Erro ao acessar!</strong> Você precisa estar logado p/ acessar o Sistema.
					</div>';
	}
 }
}

	if(isset($_POST['logar'])){
		//recuperar dados form
		$usuario = trim(strip_tags($_POST['usuario']));
		$senha = trim(strip_tags($_POST['senha']));
		//selecionar banco de dados
		$select = "SELECT * from login WHERE BINARY usuario=:usuario AND BINARY senha=:senha";
		try{
			$result = $conexao->prepare($select);
			$result->bindParam(':usuario', $usuario, PDO::PARAM_STR);
			$result->bindParam(':senha', $senha, PDO::PARAM_STR);
			$result->execute();
			$contar = $result->rowCount();
			if($contar>0){
				$usuario = $_POST['usuario'];
				$senha	 = $_POST['senha'];
				$_SESSION['usuarioj'] = $usuario;
				$_SESSION['senhaj'] = $senha;
				echo '<div class="alert alert-success">
                      <button type="button" class="close" data-dismiss="alert">×</button>
                      <strong>Logado com Sucesso!</strong> Redirecionando para o sistema.
                </div>';
				//redirecionamento
				header("Refresh: 3, home.php?acao=welcome");
			}else{
				echo '<div class="alert alert-danger">
                      <button type="button" class="close" data-dismiss="alert">×</button>
                      <strong>Erro ao logar!</strong> Os dados estão incorretos.
                </div>';
			}

		}catch(PDOException $e){
			echo $e;
		}
	}
	?>



<div class="account-container">
	
	<div class="content clearfix">
		
		<form action="#" method="post" enctype="multipart/form-data">
		
			<h1>Faça seu Login</h1>		
			
			<div class="login-fields">
				
				<p>Entre com seus dados:</p>
				
				<div class="field">
					<label for="username">usuário</label>
					<input type="text" id="username" name="usuario" value="" placeholder="usuário" class="login username-field" />
				</div> <!-- /field -->
				
				<div class="field">
					<label for="password">senha:</label>
					<input type="password" id="password" name="senha" value="" placeholder="senha" class="login password-field"/>
				</div> <!-- /password -->
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">



				<input type="submit" name="logar" value="Entrar no Sistema" class="button btn btn-success btn-large">
				
			</div> <!-- .actions -->
			
			
			
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->


<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/bootstrap.js"></script>

<script src="js/signin.js"></script>

</body>

</html>
