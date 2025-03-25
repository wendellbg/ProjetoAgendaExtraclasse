<?php

$filePath = '../../global/data/professor.data.json';


$jsonData = file_get_contents($filePath);
$materias = json_decode($jsonData, true);
$data = [];
if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);
    foreach ($materias as $materia) {

        if ($materia['id'] == $id) {
            $data = $materia;
            break;
        }
    }
}

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include '../../global/php/head.php' ?>
    <title>Professor</title>
    <link rel="stylesheet" href="./css/style.css">

</head>


<body>
    <div class="container">

        <?php include '../../global/header/Header.php' ?>
        <Main class="Main-container">
            Professor
        </Main>
    </div>
</body>

</html>