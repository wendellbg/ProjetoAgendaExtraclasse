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
                        <button class="subtitle" onclick="window.location.href='/pages/cad-aluno/index.php?id=<?= $materia['id'] ?>'">Agendar</button>

                    </div>
                <?php
                }

                ?>
            </section>
        </Main>
    </div>
</body>

</html>