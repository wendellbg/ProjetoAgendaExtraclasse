<?php
session_start();
//alterar isso futuramente quando tiver banco de dados
$filePath = '../model/login-bd.php';
include $filePath;
$login = new Login();
if (!file_exists($filePath)) {
    die("caminho invalido!");
}

$data = $login->getMAtricula($_POST['matricula'] ?? '');

if (!empty($_POST)) {
    $matricula = $_POST['matricula'] ?? null;
    $tipoVinculo = $_POST['tipo_vinculo'] ?? null;

    if ($data !== $matricula) {
        try {
            $login->post(
                $_POST['data_nascimento'] ?? '',
                $_POST['email'] ?? '',
                $matricula,
                $_POST['nome_usual'] ?? '',
                $tipoVinculo,
                $_POST['url_foto_75x100'] ?? '',
                $_POST['url_foto_150x200'] ?? '',
                $_POST['curso'] ?? '',
                $_POST['nome'] ?? ''
            );

            $_SESSION['message'] = "Dados atualizados com sucesso!";
            header('Location: /pages/perfil');
            exit; // Garante que o script pare aqui

        } catch (Exception $e) {
            $_SESSION['message'] = "Erro ao salvar os dados: " . $e->getMessage();
            header('Location: /pages/perfil');
            exit;
        }
    } else {
        if (!empty($tipoVinculo) && !empty($matricula)) {
            $_SESSION['tipo_vinculo'] = $tipoVinculo;
            $_SESSION['matricula'] = $matricula;
            header('Location: /pages/home');
            exit;
        }
    }
}

printf($message);
