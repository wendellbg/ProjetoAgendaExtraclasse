<?php
// alterar isso futuramente quando tiver banco de dados
$filePath = '../../../global/data/data.json';
$data = [];
if (file_exists($filePath)) {
    $json = file_get_contents($filePath);
    $data = json_decode($json, true) ?? [];
}
/* no formulario la em /pages/home a aplicação cata os dados no data.json que futuramente vai ser atualizada pro banco e traz no formulario, para o usuario preencher o que falta, no caso vai 
faltar somente o telefone e a senha para logar na aplicação, e explicado em user.post.php o funcionamento desse codigo, assim que o usuario enviar os dados preenchidos ele e enviado para a home
o formulario não sobrescreve dados que não foram preenchidos, dados que não vão ser alterados não recebem o que vem do $_post e seus inputs são disabled*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updatedData = [
        'data_nascimento' =>  $data['data_nascimento'],
        'email' => $_POST['email'] ?? $data['email'],
        'matricula' =>  $data['matricula'],
        'nome_usual' => $_POST['nome_usual'] ?? $data['nome_usual'],
        'tipo_vinculo' =>  $data['tipo_vinculo'],
        'url_foto_75x100' =>  $data['url_foto_75x100'],
        'url_foto_150x200' =>  $data['url_foto_150x200'],
        'curso' =>  $data['curso'],
        'nome' =>  $data['nome'],
        'senha' => $_POST['senha'] ?? $data['senha'],
        'telefone' => $_POST['telefone'] ?? $data['telefone'],
    ];
    try {
        file_put_contents($filePath, json_encode($updatedData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $message = "Dados atualizados com sucesso!";
    } catch (Exception $e) {
        $message = "Erro ao salvar os dados: " . $e->getMessage();
    }
    $data = $updatedData;
    header('Location: /pages/home');
}
