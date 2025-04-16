<?php
session_start();
$filePath = '../model/login-bd.php';
include($filePath);
$login = new Login();


if (!empty($_POST)) {
    $matricula = $_POST['matricula'] ?? null;
    $tipoVinculo = $_POST['tipo_vinculo'] ?? null;
    $image75x100 =  "https://suap.ifg.edu.br/" . $_POST['url_foto_75x100'];
    $image150x200 = "https://suap.ifg.edu.br/" . $_POST['url_foto_150x200'];
    $data = $login->getMAtricula($matricula);
    if (empty($data)) {
        $success = $login->post(
            $_POST['data_nascimento'],
            $_POST['email'],
            $_POST['matricula'],
            $_POST['nome_usual'],
            $_POST['tipo_vinculo'],
            $image75x100,
            $image150x200,
            $_POST['curso'],
            $_POST['nome']
        );
        if ($success) {
            $_SESSION['tipo_vinculo'] = $tipoVinculo;
            $_SESSION['matricula'] = $matricula;
            header('Location: /pages/perfil');
        }
        return;
    } else {
        $_SESSION['tipo_vinculo'] = $tipoVinculo;
        $_SESSION['matricula'] = $matricula;
        header('Location: /pages/home');
    }
}
