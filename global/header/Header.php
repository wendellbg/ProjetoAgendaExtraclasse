<?php
$filePath = '../../login/model/login-bd.php';
include '../../global/php/guard.php';
require($filePath);
$login = new Login();
if (file_exists($filePath)) {
    $data  = $login->getUser($_SESSION['matricula']);
    $matricula = $login->getMatricula($_SESSION['matricula']);
}
if (!empty($matricula)) {

?>
    <header>
        <div class="img-container">
            <img src="/assets/img/logo_ifg.png" alt="logo ifg">
            <div class="mobile-button-container">
                <button id="button-mobile"><i class="fa-solid fa-bars"></i></button>
            </div>
        </div>
        <!-- <div class="bell-container">
            <button id="button-bell">
                <i class="fa-solid fa-bell fa-2xl"></i>
            </button>
            <div class="notify">
                <!-- cards que vão receber a notificação -->
        <!-- <div class="card-notify">
                    <p class="paragraph"> placeholder <button>deletar</button></p>
                </div>

            </div>
        </div>  -->
    </header>
    <nav class="mobile">
        <div class="user-container">

            <p class="paragraph"><?php echo htmlspecialchars($data['nome_usual']); ?></p>

            <img src="<?php echo "https://suap.ifg.edu.br/" . htmlspecialchars($data['url_foto_150x200']) ?>" alt="user-image">
        </div>
        <!-- adicionar mais links pras paginas conforme for colocando mais -->
        <ul class="navigation-container">
            <?php
            echo hidePage(['aluno', 'professor', 'servidor']) ? "<li><a href='/pages/home' class='subtitle'>Home</a></li>" : "";
            echo hidePage(['aluno', 'professor', 'servidor']) ? "<li><a href='/pages/perfil' class='subtitle'>Perfil</a></li>" : "";
            echo hidePage(['professor', 'servidor']) ? "<li><a href='/pages/cad-professor' class='subtitle'>Cadastro</a></li>" : "";
            echo hidePage(['servidor']) ? " <li><a href='/pages/mediador' class='subtitle'>Mediador</a></li>" : "";
            echo hidePage(['aluno', 'professor', 'servidor']) ? "<li><a href='/pages/calendario' class='subtitle'>Calendario</a></li>" : ""

            ?>
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
            suap.logout();
            deletarCookie("PHPSESSID");
            deletarCookie("suapScope");
            deletarCookie("suapToken");
            deletarCookie("suapTokenExpirationTime");
            window.location.href = "/";
        } else {
            deletarCookie('PHPSESSID')
            window.location.href = '/'
        }
    });

    $("#button-mobile").on('click', (e) => {
        e.stopPropagation();
        $('.mobile').show();
    })

    $(document).on('click', (e) => {
        if (!$(e.target).closest('.mobile').length && !$(e.target).is('#button-mobile')) {
            $('.mobile').hide();
        }
    })
    
</script>