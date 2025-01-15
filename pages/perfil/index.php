<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../../global/php/head.php' ?>
    <link rel="stylesheet" href="./css/style.css">
    <title>perfil</title>
</head>

<body>
    <div class="container">
        <?php include '../../global/header/Header.php' ?>
        <Main class="Main-container">
            <form class="perfil-container">
                <h3 class="subtitle">Os dados não serão alterados no suap!</h3>
                <div class="input-perfil-container">
                    <label for="name">
                        <span class="paragraph">Nome</span>
                        <input class="paragraph" type="text" id="name">
                    </label>

                    <label for="email">
                        <span class="paragraph">Email</span>
                        <input class="paragraph" type="email" id="email">
                    </label>

                    <label for="matricula">
                        <span class="paragraph">Matricula</span>
                        <input class="paragraph" type="text" id="matricula">
                    </label>

                    <label for="curso">
                        <span class="paragraph">Curso</span>
                        <input class="paragraph" type="text" id="curso">
                    </label>
                    <label for="senha">
                        <span class="paragraph">senha</span>
                        <input class="paragraph" type="password" id="senha">
                    </label>

                    <label for="telefone">
                        <span class="paragraph">telefone</span>
                        <input class="paragraph" type="text" id="telefone">
                    </label>
                </div>

                <div class="button-perfil-container ">
                    <input type="submit" value="Alterar" class="button-perfil subtitle">
                </div>
            </form>

        </Main>
    </div>

</body>

</html>