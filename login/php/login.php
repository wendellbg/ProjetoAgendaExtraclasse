<?php
session_start();
$filePath = '../model/login-bd.php';
require($filePath);
$login = new Login();

if (empty($_POST) or (empty($_POST['matricula']) or (empty($_POST['senha'])))) {
    header('Location: /');
} else {
    $hasLogin = $login->HasLogin($_POST['matricula'], $_POST['senha']);;
    if ($hasLogin) {
        header('Location: /pages/home');
    } else {
        printf("usuario ou senha incorretos");
        printf("<a href='/'>Voltar login</a>");
    }
}
