<?php

$filePath = '../../global/data/perfil.mock.json';


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
<html lang="en">

<head>
    <?php include '../../global/php/head.php' ?>
    <title>Aluno</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="container">
        <?php include '../../global/header/Header.php' ?>
        <Main class="Main-container">
            <div class="cadastro-container">
                <form action="./php/cadAlunoPost.php" method="post" class="form-cadastro">
                    <div class="cad-title">
                        <h3 class="subtitle">
                            <?php
                            if (!empty($data)) {
                                echo htmlspecialchars($data['nome_materia']);
                            } else {
                                echo "Sem materia selecionada";
                            }
                            ?>
                        </h3>
                    </div>
                    <div class="cad-input-container">
                        <label for="assunto">
                            <span class="paragraph">Assunto</span>
                            <input class="paragraph" type="text" id="assunto" name="assunto">
                        </label>
                        <label for="data">
                            <span class="paragraph">Data</span>
                            <input class="paragraph" type="text" id="data" name="data">
                        </label>
                        <label for="hora">
                            <span class="paragraph">Hora</span>
                            <input class="paragraph" type="text" id="hora" name="hora">
                        </label>
                        <label for="observacao">
                            <span class="paragraph">Observação</span>
                            <input class="paragraph" type="text" id="observacao" name="observacao">
                        </label>

                    </div>
                    <div class="button-perfil-container">
                        <input type="submit" value="Cadastrar" class="button-perfil subtitle">
                    </div>
                </form>
            </div>

        </Main>
    </div>
</body>




</html>