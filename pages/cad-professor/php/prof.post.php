<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $materia = $_POST['materia'] ?? '';
    $curso = $_POST['curso'] ?? '';
    $dia = $_POST['dia'] ?? '[]';
    $img = $_POST['imageName'];
    $filePath = 'dados.json';

    $novoDado = [
        'materia' => $materia,
        'curso' => $curso,
        'image' => $img,
        'dia' => json_decode($dia, true),
    ];

    // Verifica se o arquivo já existe e lê os dados anteriores
    if (file_exists($filePath)) {
        $dadosAnteriores = json_decode(file_get_contents($filePath), true);
        if (!is_array($dadosAnteriores)) {
            $dadosAnteriores = [];
        }
    } else {
        $dadosAnteriores = [];
    }

    $dadosAnteriores[] = $novoDado;

    file_put_contents($filePath, json_encode($dadosAnteriores,  JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    echo "Dados salvos com sucesso!";
} else {
    echo "Método inválido.";
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['image'])) {

    $imgBase64 = $_POST['image'];


    if (preg_match('/^data:image\/(\w+);base64,/', $imgBase64, $matches)) {

        $imgBase64 = substr($imgBase64, strpos($imgBase64, ',') + 1);
        $imageData = base64_decode($imgBase64);


        if ($imageData === false) {
            echo "Erro ao decodificar a imagem base64.";
            exit;
        }


        $fileName = 'imagem/' . $img;


        if (!file_exists('imagem')) {
            mkdir('imagem', 0777, true);
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
