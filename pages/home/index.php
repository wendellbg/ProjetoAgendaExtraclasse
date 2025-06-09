<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include '../../global/php/head.php';
    ?>
    <link rel="stylesheet" href="./css/style.css">
    <title>Home</title>
</head>

<body>


    <div class="container">
        <?php include '../../global/header/Header.php' ?>


        <Main class="Main-container">
            <section class="card-container">
                <!-- guard -->
                <?php
                $value = ['aluno', 'professor', 'servidor'];
                guard($value);
                ?>

                <?php

                $filePath = '../../global/data/professor.data.json';
                $jsonData = file_get_contents($filePath);
                $materias = json_decode($jsonData, true);
                foreach ($materias as $materia) {
                ?>
                    <div class="card">
                        <div class="img-home-container">
                            <img src="<?php echo htmlspecialchars($materia['teacherImg']) ?>" alt="imagem professor">
                        </div>
                        <h3 class="subtitle"><?= htmlspecialchars($materia['teacher_name']) ?></h3>
                        <?php

                        $idAgendar = htmlspecialchars($materia['teacherID']);;
                        echo hidePage(['aluno']) ? " <a class='subtitle card-button' href='/pages/cad-aluno/index.php?id=$idAgendar'>Agendar</a>" :
                            "<div class='card-buttons_container'>
                            <a href='' class='card-button subtitle'>Alterar</a>
                            <a href='/pages/professor/?id=$idAgendar' class='subtitle ver-materias-button'>Ver materias</a>
                        </div>"
                        ?>



                    </div>
                <?php
                }

                ?>
            </section>
        </Main>
    </div>
</body>

</html>