<?php

if (isset($_SESSION['tipo_vinculo'])) {
?>
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
                    <p class="paragraph"><?php echo "Notificação placeholder"; ?> <button >deletar</button></p>
                </div>

            </div>
        </div>
    </header>
    <nav>
        <div class="user-container">
            <?php


            $filePath = '../../global/data/data.json';


            if (file_exists($filePath)) {

                $jsonData = file_get_contents($filePath);

                $userData = json_decode($jsonData, true);
            } else {

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
            <li><a href="/pages/cad-professor" class="subtitle">Cadastro</a></li>
            <?php
            if (true) {
            ?>
                <li><a href="/pages/mediador" class="subtitle">Mediador</a></li>
            <?php } ?>
            <li><a href="/pages/calendario" class="subtitle">Calendario</a></li>
            <li><a href="/pages/aluno" class="subtitle">Aluno</a></li>
            <li><a href="/pages/professor" class="subtitle">Professor</a></li>
            <li><a href="/pages/ata" class="subtitle">ata</a></li>
        </ul>

        <div class="button-exit-container">
            <button id="suap-logout-button" class="paragraph"> <i class="fa-solid fa-user-minus"></i> <span class="subtitle">sair</span></button>
        </div>
    </nav>
<?php
} else {
    header('Location: /');
}

?>
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
    var suap = new SuapClient(SUAP_URL, CLIENT_ID, REDIRECT_URI, SCOPE);
    suap.init();

    function deletarCookie(nome) {
        document.cookie = nome + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/";
    }

    $("#suap-logout-button").click(function() {
        if (suap.isAuthenticated()) {
            deletarCookie('PHPSESSID')
            suap.logout()
        } else {
            deletarCookie('PHPSESSID')
            window.location.href = '/'
        }
    });
</script>