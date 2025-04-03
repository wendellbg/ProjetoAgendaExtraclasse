<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    var_dump($_POST);
    $assunto = $_POST['assunto'];
    $materia = $_POST['materia'];
    $data = $_POST['data'];
    $idMateria = [
        "id_materia" => $_POST['idMateria'],
        "userID" => '1'
    ];
    $dateTime = DateTime::createFromFormat('d/m/Y', $data);
    if ($dateTime) {
        $dataFormatada = $dateTime->format('Y-m-d');
    }
    $observacao = "";
    $id = uniqid();
    $filePath = '../../../global/data/aluno.data.json';

    $dataArr =  [
        'idGroup' => $idMateria,
        'title' => $materia,
        'start' => $dataFormatada,
        'color' => '#257e4a'
    ];

    $novoDado = [
        'id' => $id,
        'assunto' => $assunto,
        'data' => $dataArr,
        'imprevisto' => $observacao,
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
}
