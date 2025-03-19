<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../../global/php/head.php' ?>
    <link rel="stylesheet" href="./css/style.css">
    <title>Home</title>

</head>

<body>


    <div class="container">
        <?php include '../../global/header/Header.php' ?>


        <Main class="Main-container">
            <section class="card-container">

                <?php
                session_start();
                $filePath = '../../global/data/perfil.mock.json';
                $jsonData = file_get_contents($filePath);
                $materias = json_decode($jsonData, true);
                if (isset($_SESSION['tipo_vinculo'])) {
                    if (strtolower($_SESSION['tipo_vinculo']) == strtolower('aluno')) {
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
                    }
                } else {
                    header('Location: /');
                }
                ?>
            </section>
        </Main>
    </div>
</body>

</html>