<?php

$filePath = '../../global/data/page.professor.data.json';


$jsonData = file_get_contents($filePath);
$materias = json_decode($jsonData, true);
$dataProf = [];
if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);
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
                    <?php foreach ($materias as $materia) {

                        $IsProfessor =  strtolower($_SESSION['tipo_vinculo']) === "professor";
                        $IsServidor =   strtolower($_SESSION['tipo_vinculo']) === "servidor";


                        $shouldDisplay = false;

                        if ($IsProfessor && $materia['id'] === $id) {
                            $shouldDisplay = true;
                        } elseif ($IsServidor && $materia['userID'] === $id) {
                            $shouldDisplay = true;
                        }

                        if ($shouldDisplay) {
                    ?>
                            <div class="card">
                                <div class="title-container subtitle">
                                    <h3><?php echo htmlspecialchars($materia['nome_materia']); ?></h3>
                                    <?php
                                    //arrumar isso aqui depois quando tiver o banco de dados linkado
                                    echo $IsServidor
                                        ? "<a class='ata-btn' href='/pages/ata/index.php?id=" . htmlspecialchars($materia['id']) . "'>Ver ata</a>"
                                        : htmlspecialchars($materia['data']);
                                    ?>
                                </div>
                                <div class="body-card paragraph">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Matricula</th>
                                                <th>Aluno</th>
                                                <th>Assunto</th>
                                                <th>imprevisto</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($materia['aluno'] as $alunos) { ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($alunos['matricula']); ?></td>
                                                    <td><?php echo htmlspecialchars($alunos['nome_aluno']); ?></td>
                                                    <td><?php echo htmlspecialchars($alunos['assunto']); ?></td>
                                                    <td><?php echo $alunos['imprevisto'] ? htmlspecialchars($alunos['imprevisto']) : "sem imprevisto"; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="btn-open-modal-container">
                                    <p class="paragraph"><?php echo htmlspecialchars($materia['hora']); ?></p>
                                    <?php
                                    echo $IsProfessor
                                        ? "<button class='open-modal btn-enviar subtitle' data-id='" . $materia['id'] . "'>Chamada</button>"
                                        : "";
                                    ?>
                                </div>
                            </div>

                            <!-- modal -->
                            <div class="my-dialog" id="modal-<?php echo $materia['id']; ?>">
                                <form action="" method="post" class="form-imprevisto paragraph">
                                    <h3 class="subtitle">Chamada</h3>
                                    <?php foreach ($materia['aluno'] as $alunos) { ?>
                                        <label for="">
                                            <span><?php echo htmlspecialchars($alunos['nome_aluno']); ?></span>
                                            <select name="chamada[<?php echo $alunos['nome_aluno']; ?>]">
                                                <option value="P">P</option>
                                                <option value="F">F</option>
                                            </select>
                                        </label>
                                    <?php } ?>

                                    <div class="btn-container">
                                        <button type="button" class="close-dialog close" data-id="<?php echo $materia['id']; ?>">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                        </button>
                                        <button type="submit" class="btn-enviar subtitle">Enviar</button>
                                    </div>
                                </form>
                            </div>
                    <?php
                        } // end if shouldDisplay
                    } // end foreach 
                    ?>
                </div>
            </div>
            <?php
            if (!empty($_POST)) {
                var_dump($_POST);
            }

            ?>
        </Main>
    </div>
</body>
<script>
    $(document).ready(function() {
        $(document).on("click", ".open-modal", function() {
            let modalId = $(this).data("id");
            $("#modal-" + modalId).fadeIn();
        });

        $(document).on("click", ".close-dialog", function() {
            let modalId = $(this).data("id");
            $("#modal-" + modalId).fadeOut();
        });
    });
</script>


</html>