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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['image'])) {

    $imgBase64 = $_POST['image'];


    if (preg_match('/^data:image\/(\w+);base64,/', $imgBase64, $matches)) {

        $imgBase64 = substr($imgBase64, strpos($imgBase64, ',') + 1);
        $imageData = base64_decode($imgBase64);


        if ($imageData === false) {
            echo "Erro ao decodificar a imagem base64.";
            exit;
        }
        $imageName = 'imagem_' . uniqid() . '.' . $matches[1];

        $fileName = '../../../global/data/imagem/' . $imageName;


        if (!file_exists('../../../global/data/imagem')) {
            mkdir('../../../global/data/imagem', 0777, true);
        }


        if (file_put_contents($fileName, $imageData)) {
            echo "Imagem enviada e salva com sucesso!";
        } else {
            echo "Erro ao salvar a imagem.";
        }
    } else {
        echo "Formato de imagem inválido.";
    }
} else {
    echo "Nenhuma imagem recebida.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login->changeImage($fileName, $_SESSION['matricula']);
}
