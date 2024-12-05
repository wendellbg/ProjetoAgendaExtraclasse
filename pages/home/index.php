<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once '../../global/php/head.php' ?>
    <title>Home</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <span id="content"></span>
    <button id="suap-logout-button">sair</button>

    <script>
       
        function getAccessTokenFromURL() {
            const hash = window.location.hash.substring(1); 
            const params = new URLSearchParams(hash); 
            return params.get('access_token'); 
        }

       
        const accessToken = getAccessTokenFromURL();

        if (!accessToken) {
            console.error('Token de acesso não encontrado na URL.');
        } else {
            // Fazer a requisição com jQuery usando o token
            $.ajax({
                url: 'https://suap.ifg.edu.br/api/v2/minhas-informacoes/meus-dados/',
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + accessToken, // Adiciona o token no cabeçalho
                    'Accept': 'application/json'
                },
                success: function(data) {
                    $('#content').text(JSON.stringify(data, null, 2));
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Erro na requisição:', textStatus, errorThrown);
                }
            });
        }
        $("#suap-logout-button").click(function () {
            var suap = new SuapClient(SUAP_URL, CLIENT_ID, REDIRECT_URI, SCOPE);
            suap.logout();
        });
    </script>

    <script src="../../suap/js.cookie.js"></script>
    <script src="../../suap/settings.js"></script>
    <script src="../../suap/client.js"></script>
</body>

</html>