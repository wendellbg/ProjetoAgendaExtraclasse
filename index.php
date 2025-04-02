<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Login</title>
    <?php include_once 'global/php/head.php' ?>
    <link rel="stylesheet" href="./css/style.css">

</head>

<body>
    <form class="login-form" method="POST" action="./login/php/login.php">
        <img src="./assets/img/logo_ifg.png" alt="logo ifg">
        <div class="inputs_container">
            <label class="label-container">
                <span class="paragraph">Matrícula</span>
                <input id="login" type="text" class="paragraph" name="matricula">
            </label>

            <label class="label-container">
                <span class="paragraph">Senha</span>
                <input id="password" type="password" class="paragraph" name="senha">
            </label>
        </div>

        <div class="button-container">
            <button type="submit" class="subtitle">Login</button>
            <p class="paragraph">Primeiro login? <a class="paragraph" id="suap-login-button">clique aqui</a></p>
        </div>
    </form>
    <script src="/suap/client.js"></script>
    <script src="/suap/js.cookie.js"></script>
    <script src="/suap/settings.js"></script>


    <!-- login pelo suap -->
    <script>
        $(document).ready(function() {
            var suap = new SuapClient(SUAP_URL, CLIENT_ID, REDIRECT_URI, SCOPE);
            suap.init();
            $("#suap-login-button").attr('href', suap.getLoginURL());
            if (suap.isAuthenticated()) {
                $('.is-authenticated').removeClass("is-hidden");
                $('#token').text(suap.getToken().getValue());
                $('#validade_token').text(suap.getToken().getExpirationTime());
                $("#escopos_autorizados").text(suap.getToken().getScope());
                $("#escopos").val(suap.getToken().getScope());

                const accessToken = suap.getToken().getValue();
                console.log(accessToken);
                if (!accessToken) {
                    console.error('Token de acesso não encontrado na URL.');
                }
                $.ajax({
                    url: 'https://suap.ifg.edu.br/api/v2/minhas-informacoes/meus-dados/',
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + accessToken,
                        'Accept': 'application/json'
                    },
                    success: function(data) {
                        const dataFilter = (data) => {
                            objFilter = {
                                data_nascimento: data.data_nascimento,
                                email: data.email,
                                matricula: data.matricula,
                                nome_usual: data.nome_usual,
                                tipo_vinculo: data.tipo_vinculo,
                                url_foto_75x100: data.url_foto_75x100,
                                url_foto_150x200: data.url_foto_150x200,
                                curso: data.vinculo.curso,
                                nome: data.vinculo.nome,

                            };
                            return objFilter;
                        };

                        saveUserData(dataFilter(data));
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Erro na requisição:', textStatus, errorThrown);
                    }
                });

                function saveUserData(data) {
                    $.ajax({
                        url: "./login/php/suap.login.php",
                        method: "POST",
                        data: data,
                        success: function(response) {
                            window.location.href = "/pages/perfil";
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error("Erro ao enviar os dados:", textStatus, errorThrown);
                        },
                    });
                };
            }
        });
    </script>

</body>

</html>