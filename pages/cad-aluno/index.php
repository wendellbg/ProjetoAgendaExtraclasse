<?php

$filePathTeacher = '../../global/data/professor.data.json';


$jsonData = file_get_contents($filePathTeacher);
$materias = json_decode($jsonData, true);
$dataProf = [];
if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);
    foreach ($materias as $materia) {

        if ($materia['id'] == $id) {
            $dataProf = $materia;
            break;
        }
    }
}

include './php/getNextDays.php';
$diasFilePath = '../../global/data/calendario/json/Inicio_fim.json';
$diaJsn = file_get_contents($diasFilePath);
$diaData = json_decode($diaJsn, true);
$dias = array_column($dataProf["dia"], "dia");
if ($diaData) {
    foreach ($diaData as $Inicio_fim) {
        date_default_timezone_set('America/Sao_Paulo');
        $dataInicial = date('Y-m-d');

        var_dump($dataInicial);
        $dataFinal = $Inicio_fim['fim_semestre'];
    }
}
$datas =  json_decode(getNextDaysOfWeek($dias, $dataInicial, $dataFinal), true);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include '../../global/php/head.php' ?>
    <title>Aluno</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="container">
        <?php include '../../global/header/Header.php' ?>

        <main class="Main-container">
            <form method="post" action="" class="form-cadastro">
                <div class="cad-title">
                    <h3 class="subtitle">
                        <?php
                        if (!empty($dataProf)) {
                            echo htmlspecialchars($dataProf['teacher_name']);
                        } else {
                            echo "Sem matéria selecionada";
                        }
                        ?>
                    </h3>
                </div>
                <div class="cad-input-container">
                    <label for="assunto">
                        <span class="paragraph">Assunto
                            <br>
                            <span>Informar qual assunto da disciplina que está com dúvidas.</span>
                        </span>
                        <input class="paragraph" type="text" id="assunto" name="assunto">
                    </label>
                    <label for="disciplina">
                        <span class="paragraph">Disciplina <br>
                            <span class="paragraph">Informar a disciplina que está com dúvidas.</span>
                        </span>

                        <input class="paragraph" type="text" id="disciplina" name="disciplina">
                    </label>

                    <!-- curso -->
                    <label for="" class="curso">
                        <span class="paragraph">Curso</span>
                        <input class="paragraph" type="text" name="curso" value="<?php echo $data['curso'] ?>">
                    </label>
                    <!-- data -->
                    <label for="data">
                        <span class="paragraph">Data</span>
                        <select name="data" id="data" class="paragraph">
                            <?php
                            if ($datas) {
                                foreach ($datas as $dia) {
                                    echo '<option value="' . $dia['data'] . '">' . $dia['data'] . ' - ' . $dia['dia'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </label>
                    <!-- hora -->
                    <label for="" class="hora">
                        <span class="paragraph">hora</span>
                        <input class="paragraph" type="text" name="hora">
                    </label>
                </div>
                <div class="button-perfil-container">
                    <input type="submit" value="Agendar" class="button-perfil subtitle">
                </div>
            </form>
        </main>
    </div>

</body>
<script>
    $('.form-cadastro').on('submit', (e) => {
        e.preventDefault();
        const assunto = $("[name='assunto']").val();
        const data = $("[name='data']").val();
        const curso = $("[name='curso']").val();
        const disciplina = $("[name='disciplina']").val();
        const hora = $("[name='hora']").val();
        const idMateria = <?php
                            echo isset($id)
                                ? json_encode($id, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT)
                                : '""';
                            ?>;

        let formData = new FormData();
        formData.append("assunto", assunto);
        formData.append("hora", hora);
        formData.append("curso", curso);
        formData.append("data", data);
        formData.append("materia", disciplina);
        formData.append("idMateria", idMateria);

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