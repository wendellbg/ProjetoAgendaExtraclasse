<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $materia = $_POST['teacher_name'] ?? '';
    $curso = $_POST['curso'] ?? '';
    $dia = $_POST['dia'] ?? '[]';
    $horario = $_POST['horario'];
    $local = $_POST['local'];
    $id = uniqid();
    $teacherImg = $_POST['teacherImg'];
    $teacherID = $_POST['teacherID'];
    $filePath = '../../../global/data/professor.data.json';


    $novoDado = [
        'id' => $id,
        'teacher_name' => $materia,
        'curso' => $curso,
        'dia' => json_decode($dia, true),
        'teacherImg' => $teacherImg,
        'local' => $local,
        'teacherID' => $teacherID
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
