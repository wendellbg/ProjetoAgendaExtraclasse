<header>
    <div class="img-container">
        <img src="/assets/img/logo_ifg.png" alt="logo ifg">
    </div>

    <div class="bell-container">
        <button id="button-bell">
            <i class="fa-solid fa-bell fa-2xl"></i>
        </button>
        <div class="notify">
            <!-- cards que vão receber a notificação -->
            <div class="card-notify">
                <p class="paragraph"><?php echo "Notificação placeholder"; ?></p>
            </div>

        </div>
    </div>
</header>
<nav>
    <div class="user-container">
        <?php
        // Caminho para o arquivo JSON
        $filePath = '../../global/data/data.json';

        // Verifica se o arquivo existe
        if (file_exists($filePath)) {
            // Lê o conteúdo do arquivo
            $jsonData = file_get_contents($filePath);
            // Decodifica o JSON em um array associativo
            $userData = json_decode($jsonData, true);
        } else {
            // Se o arquivo não existir, exibe uma mensagem ou define valores padrão
            $userData = [
                'nome_usual' => 'Usuário Desconhecido',
                'url_foto_150x200' => '../../assets/img/noImage.png'
            ];
        }
        ?>


        <p class="paragraph"><?php echo htmlspecialchars($userData['nome_usual']); ?></p>
        <img src="<?php echo "https://suap.ifg.edu.br/" . htmlspecialchars($userData['url_foto_150x200']) ?>" alt="user-image">
    </div>
    <!-- adicionar mais links pras paginas conforme for colocando mais -->
    <ul class="navigation-container">
        <li><a href="/pages/home" class="subtitle">Home</a></li>
        <li><a href="/pages/perfil" class="subtitle">Perfil</a></li>
    </ul>

    <div class="button-exit-container">
        <button id="suap-logout-button" class="paragraph"> <i class="fa-solid fa-user-minus"></i> <span class="subtitle">sair</span></button>
    </div>
    <button id="suap-resource-button">teste</button>
</nav>

<!-- script que abre e fecha a notificação -->
<script>
    let notify = document.querySelector('.notify')
    let verify = false;
    document.getElementById("button-bell").addEventListener('click', () => {
        verify = !verify
        if (verify) {
            notify.style.display = 'flex'
        } else {
            notify.style.display = 'none'
        }
    })
</script>
<script src="../../suap/client.js"></script>
<script src="../../suap/js.cookie.js"></script>
<script src="../../suap/settings.js"></script>
<!-- script pra receber os dados do usuario do suap -->
<script>
    $("#suap-resource-button").click(function() {
        if (suap.isAuthenticated()) {
            var scope = $("#escopos").val();
            var callback = function(response) {
                console.log(response)
            };
            suap.getResource(scope, callback);
        }
    });


    var suap = new SuapClient(SUAP_URL, CLIENT_ID, REDIRECT_URI, SCOPE);
    $("#suap-logout-button").click(function() {
        suap.logout();
    });
</script>