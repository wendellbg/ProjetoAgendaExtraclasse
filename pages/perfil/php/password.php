<?php
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
    $login->changePassword($_POST['senha'], $_SESSION['matricula']);
}
