<?php
// alterar isso futuramente quando tiver banco de dados
$filePath = '../../../global/data/data.json';
$data = [];
session_start();
if (file_exists($filePath)) {
    $json = file_get_contents($filePath);
    $data = json_decode($json, true) ?? [];
}
$filePath = '../../../login/model/login-bd.php';
require($filePath);
$login = new Login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login->put($_POST['senha'], $_POST['telefone'], $_SESSION['matricula']);
    header("location: /pages/home");
}
