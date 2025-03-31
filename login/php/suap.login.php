<?php
session_start();
//alterar isso futuramente quando tiver banco de dados
$filePath = '../../global/data/data.json';
$data = [];
if (file_exists($filePath)) {
    $json = file_get_contents($filePath);
    $data = json_decode($json, true) ?? [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($data['matricula'] !== $_POST['matricula']) {
        $updatedData = [
            'data_nascimento' => $_POST['data_nascimento'] ?? $data['data_nascimento'],
            'email' => $_POST['email'] ?? $data['email'],
            'matricula' => $_POST['matricula'] ?? $data['matricula'],
            'nome_usual' => $_POST['nome_usual'] ?? $data['nome_usual'],
            'tipo_vinculo' => $_POST['tipo_vinculo'] ?? $data['tipo_vinculo'],
            'url_foto_75x100' => $_POST['url_foto_75x100'] ?? $data['url_foto_75x100'],
            'url_foto_150x200' => $_POST['url_foto_150x200'] ?? $data['url_foto_150x200'],
            'curso' => $_POST['curso'] ?? $data['curso'],
            'nome' => $_POST['nome'] ?? $data['nome'],
            'senha' => $_POST['senha'] ?? $data['senha'],
            'telefone' => $_POST['telefone'] ?? $data['telefone'],
        ];



        if (isset($_POST['tipo_vinculo'])) {
            $_SESSION['tipo_vinculo'] = $_POST['tipo_vinculo'];
        }
        try {
            file_put_contents($filePath, json_encode($updatedData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            $message = "Dados atualizados com sucesso!";
        } catch (Exception $e) {
            $message = "Erro ao salvar os dados: " . $e->getMessage();
        }
        $data = $updatedData;
        header('Location: /pages/perfil');
    } else {
        if (isset($_POST['tipo_vinculo'])) {
            $_SESSION['tipo_vinculo'] = $_POST['tipo_vinculo'];
        }
        header('Location: /pages/home');
    }
}
