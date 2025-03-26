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
            <div class="aluno-container">
                <div class="materia-card-container">
                    <div class="card">
                        <div class="title-container subtitle">
                            <h3>Nome da materia</h3>
                            <h3>data</h3>
                        </div>
                        <div class="body-card paragraph">
                            <p>nome aluno</p>
                            <p>assunto</p>
                            <p>imprevisto</p>
                        </div>
                        <div class="btn-open-modal-container ">
                            <p class="paragraph">hora</p>
                            <button id="open-modal" class="btn-enviar subtitle">Chamada</button>
                        </div>

                    </div>
                </div>

                <!-- modal -->
                <div id="my-dialog">
                    <form action="" class="form-imprevisto paragraph">
                        <h3 class="subtitle">Chamada</h3>
                        <label for="">
                            <span>Aluno</span>
                            <select name="chamada" id="">
                                <option value="Presença">P</option>
                                <option value="Falta">F</option>
                            </select>
                        </label>

                        <div class="btn-container">
                            <button type="button" id="close-dialog" class="close"><i class="fa-solid fa-circle-xmark"></i></button>
                            <button type="submit" class="btn-enviar subtitle">Enviar</button>

                        </div>
                    </form>
                </div>

            </div>
        </Main>
    </div>
</body>
<script>
    //abrir fechar modal
    $('#open-modal').on('click', () => {
        $('#my-dialog').show(); // Exibe o modal
    });

    $('#close-dialog').on('click', () => {
        $('#my-dialog').hide(); // Esconde o modal
    });
</script>

</html>