<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../../global/php/head.php' ?>

    <title>Mediador</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>

    <div class="container">


        <?php include '../../global/header/Header.php' ?>


        <Main class="Main-container">
            <form action="./php/mediador.php" method="POST" class="form-mediador" enctype="multipart/form-data">
                <label for="">
                    <span class="paragraph">Inicio semestre</span>
                    <input  class="paragraph" type="date" name="inicio_semestre">
                </label>

                <label for="">
                    <span class="paragraph">Fim semestre</span>
                    <input class="paragraph" type="date" name="fim_semestre">
                </label>
                <label for="pdf">
                    <span class="paragraph">
                        Selecione o pdf do calendario academico
                    </span>
                    <input class="paragraph" type="file" name="pdf" id="pdf" accept="application/pdf">
                </label>
                <div class="button-container">
                    <button type="submit" class="button-form">Enviar</button>
                </div>
            </form>

        </Main>
    </div>
</body>

</html>