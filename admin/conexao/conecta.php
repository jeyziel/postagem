<?php
    try {
        $conexao = new PDO('mysql:host=localhost;dbname=sistema', 'root', '');
        $conexao ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $error){
        echo 'ERROR:' . $error->getMessage();
    }