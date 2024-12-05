<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Login</title>
    <?php include_once 'global/php/head.php'?>
    <link rel="stylesheet" href="css/style.css">
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
            <!-- Botão para redirecionar para o SUAP -->
            <a id="suap-login-button" href="#" class="paragraph">Não tem login? Clique aqui!</a>
            <button type="submit" class="subtitle">Login</button>
        </div>
    </form>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    /suap/
    <script src="/suap/js.cookie.js"></script>
    <script src="/suap/settings.js"></script>
    <script src="/suap/client.js"></script>
    <script>
        $(document).ready(function () {
            
            var suap = new SuapClient(SUAP_URL, CLIENT_ID, REDIRECT_URI, SCOPE);
            suap.init();

            
            var loginURL = suap.getLoginURL();
            console.log("Login URL:", loginURL); // Log para depuração
            $("#suap-login-button").attr('href', loginURL);

            
            if (suap.isAuthenticated()) {
                console.log("Usuário autenticado!");
                // Exibir informações do token para depuração (remova em produção)
                console.log("Token:", suap.getToken().getValue());
                console.log("Escopo:", suap.getToken().getScope());
                console.log("Expiração:", suap.getToken().getExpirationTime());
            } else {
                console.log("Usuário não autenticado.");
            }
        });
    </script>
</body>

</html>



