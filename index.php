<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Login</title>
    <?php include_once 'global/php/head.php' ?>
    <link rel="stylesheet" href="./css/style.css">

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
            <p class="paragraph">Primeiro login? <a class="paragraph" id="suap-login-button">clique aqui</a></p>
        </div>
    </form>
    <script src="js/script.js"></script>
    <script src="/suap/client.js"></script>
    <script src="/suap/js.cookie.js"></script>
    <script src="/suap/settings.js"></script>

    <script>
        var suap = new SuapClient(SUAP_URL, CLIENT_ID, REDIRECT_URI, SCOPE);
        suap.init();
        $(document).ready(function() {
            $("#suap-login-button").attr('href', suap.getLoginURL());
            if (suap.isAuthenticated()) {
                $('.is-authenticated').removeClass("is-hidden");
                $('#token').text(suap.getToken().getValue());
                $('#validade_token').text(suap.getToken().getExpirationTime());
                $("#escopos_autorizados").text(suap.getToken().getScope());
                $("#escopos").val(suap.getToken().getScope());
            } else {
                $('.is-anonymous').removeClass("is-hidden");
            }
        });
        
        
    </script>
</body>

</html>