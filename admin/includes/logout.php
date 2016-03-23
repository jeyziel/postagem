<?php
//destruir sessao
if(isset($_REQUEST['sair'])){
    session_destroy();
    session_unset($_SESSION['usuarioj']);
    session_unset($_SESSION['senhaj']);
    header("Location: index.php");
}
?>