<?php
ob_start();
session_start();
//se nao existir senha nem usuario no banco de dados vá para index.php
if(!isset($_SESSION['usuarioj']) && (!isset($_SESSION['senhaj']))){
    header("location:index.php?acao=negado");exit;
}
include("conexao/conecta.php");
include("includes/logout.php");
?>
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="utf-8">
    <title>Jeyziel Sistema de Postagem</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
          rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/pages/dashboard.css" rel="stylesheet">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="js/jquery-1.7.2.min.js"></script>
    <script src="js/jquery.maskedinput.js" type="text/javascript"></script>