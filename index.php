<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Login</title>
    <?php include_once 'global/php/head.php' ?>
    
</head>

<body>
    <form class="login-form">
        <img src="./assets/img/logo_ifg.png" alt="logo ifg">
        <div class="inputs_container">
            <label class="label-container">
                <span class="paragraph">Matrícula</span>
                <input id="login" type="text" class="paragraph">
            </label>

            <label class="label-container">
                <span class="paragraph">Senha</span>
                <input id="password" type="password" class="paragraph">
            </label>
        </div>

        <div class="button-container">
            <button type="submit" class="subtitle">Login</button>
        </div>
    </form>
    <script src="js/script.js"></script>
</body>

</html>