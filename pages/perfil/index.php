<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../../global/php/head.php' ?>
    <link rel="stylesheet" href="./css/style.css">
    <title>perfil</title>
</head>

<body>

    <div class="container">
        <!-- alterar futuramente pro banco de dados -->
        <?php
       
        ?>
        <?php include '../../global/header/Header.php' ?>
        <Main class="Main-container">
            <form class="perfil-container" method="POST" action="./php/put.php">
                <h3 class="subtitle">Os dados não serão alterados no SUAP!</h3>
                <div class="input-perfil-container">
                    <label for="name">
                        <span class="paragraph">Nome</span>
                        <input
                            class="paragraph"
                            type="text"
                            id="name"
                            name="nome_usual"
                            value="<?= htmlspecialchars($data['nome_usual'] ?? '') ?>">
                    </label>

                    <label for="email">
                        <span class="paragraph">Email</span>
                        <input
                            class="paragraph"
                            type="email"
                            id="email"
                            name="email"
                            value="<?= htmlspecialchars($data['email'] ?? '') ?>">
                    </label>

                    <label for="matricula">
                        <span class="paragraph">Matrícula</span>
                        <input
                            class="paragraph"
                            type="text"
                            id="matricula"
                            name="matricula"
                            value="<?= htmlspecialchars($data['matricula'] ?? '') ?>" disabled>
                    </label>

                    <label for="curso">
                        <span class="paragraph">Curso</span>
                        <input
                            class="paragraph"
                            type="text"
                            id="curso"
                            name="curso"
                            value="<?= htmlspecialchars($data['curso'] ?? '') ?>" disabled>
                    </label>

                    <label for="senha">
                        <span class="paragraph">Senha</span>
                        <input
                            class="paragraph"
                            type="password"
                            id="senha"
                            name="senha"
                            value="">
                    </label>

                    <label for="telefone">
                        <span class="paragraph">Telefone</span>
                        <input
                            class="paragraph"
                            type="text"
                            id="telefone"
                            name="telefone"
                            value="<?= htmlspecialchars($data['telefone'] ?? '') ?>">
                    </label>
                </div>

                <div class="button-perfil-container">
                    <input type="submit" value="Alterar" class="button-perfil subtitle">
                </div>
            </form>

        </Main>
    </div>

</body>

</html>