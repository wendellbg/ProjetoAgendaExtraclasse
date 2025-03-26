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

include './php/getNextDays.php';
$diasFilePath = '../../global/data/calendario/json/Inicio_fim.json';
$diaJsn = file_get_contents($diasFilePath);
$diaData = json_decode($diaJsn, true);
$dias = $data['dia'];
if ($diaData) {
    foreach ($diaData as $Inicio_fim) {
        $dataInicial = $Inicio_fim['inicio_semestre'];
        $dataFinal = $Inicio_fim['fim_semestre'];
    }
}
$datas = getNextDaysOfWeek($dias, $dataInicial, $dataFinal);

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
                <form method="post" class="form-cadastro">
                    <div class="cad-title">
                        <h3 class="subtitle">
                            <?php
                            if (!empty($data)) {
                                echo htmlspecialchars($data['materia']);
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
                            <select name="data" id="" class="paragraph">
                                <?php
                                if ($datas) {
                                    foreach ($datas as $dia) {
                                ?>
                                        <option value=<?php echo $dia ?>><?php echo $dia ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </label>
                    </div>
                    <div class="button-perfil-container">
                        <input type="submit" value="Agendar" class="button-perfil subtitle">
                    </div>
                </form>
            </div>

        </Main>
    </div>
</body>

<!-- ./php/cadAlunoPost.php -->
<script>
    $('.form-cadastro').on('submit', (e) => {
        e.preventDefault();
        const assunto = $("[name='assunto']").val();
        const data = $("[name='data']").val();
        const materia = <?php
                        echo isset($data['materia'])
                            ? json_encode($data['materia'], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT)
                            : '""';
                        ?>;
        const idMateria = <?php
                            echo isset($id)
                                ? json_encode($id, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT)
                                : '""';
                            ?>;

        let formData = new FormData();
        formData.append("assunto", assunto);
        formData.append("data", data);
        formData.append("materia", materia);
        formData.append("idMateria", idMateria);
        // formData.forEach((res) => console.log(res))

        $.ajax({
            url: "./php/cadAlunoPost.php",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log("Enviado");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Erro ao enviar os dados:", textStatus, errorThrown);
            },
        });

    });
</script>


</html>