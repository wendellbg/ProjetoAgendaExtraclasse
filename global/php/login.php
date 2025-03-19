<?php
session_start();
// alterar isso futuramente quando tiver banco de dados
/* fake login com os dados dentro do data.json */
$filePath = '../data/data.json';
$data = [];
if (file_exists($filePath)) {
    $json = file_get_contents($filePath);
    $data = json_decode($json, true) ?? [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($data['matricula'] === $_POST['matricula'] && $data['senha'] === $_POST['senha']) {
        if (isset($data['tipo_vinculo'])) {
            $_SESSION['tipo_vinculo'] = $data['tipo_vinculo'];
            header('Location: /pages/home');
        }
    } else {
        header('Location: /');
    }
}
