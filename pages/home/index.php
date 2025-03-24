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
                include '../../global/php/guard.php';
                $value = ['aluno', 'professor', 'mediador'];
                guard($value);
                ?>

                <?php

                $filePath = '../../global/data/perfil.mock.json';
                $jsonData = file_get_contents($filePath);
                $materias = json_decode($jsonData, true);
                foreach ($materias as $materia) {
                ?>
                    <div class="card">
                        <div class="img-home-container">
                            <img src="<?= htmlspecialchars($materia['imagem']) ?>" alt="imagem da matéria escolhida">
                        </div>
                        <h3 class="subtitle"><?= htmlspecialchars($materia['nome_materia']) ?></h3>
                        <p class="paragraph"><?= htmlspecialchars($materia['nome_professor']) ?></p>
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