<?php
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
    $materia = $_POST['materia'] ?? '';
    $curso = $_POST['curso'] ?? '';
    $dia = $_POST['dia'] ?? '[]';
    $filePath = '../../../global/data/professor.data.json';
    $fileNamePath = '../../../global/data/data.json';


    if (file_exists($fileNamePath)) {

        $jsonData = file_get_contents($fileNamePath);

        $userData = json_decode($jsonData, true);
    }

    $novoDado = [
        'materia' => $materia,
        'curso' => $curso,
        'image' => $imageName,
        'dia' => json_decode($dia, true),
        'nome_professor' => $userData['nome']
    ];

    if (file_exists($filePath) && $imageName) {
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
