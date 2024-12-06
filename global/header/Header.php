<header>
    <div class="img-container">
    <img src="/assets/img/logo_ifg.png" alt="logo ifg">
    </div>

    <div class="bell-container">
    <button id="button-bell">
    <i class="fa-solid fa-bell fa-2xl"></i>
    </button >
    <div class="notify">
        <!-- cards que vão receber a notificação -->
    <div class="card-notify">
        <p class="paragraph">placeholder</p>
    </div>

    </div>
    </div>
</header>
<nav>
    <div class="user-container">
        <!-- pegar nome e foto do suap e arrumar aqui depois -->
    <p class="paragraph">usuario nome</p>
    <img src="/assets/img/imageTest.jpeg" alt="user-image">
    </div>
    <!-- adicionar mais links pras paginas conforme for colocando mais -->
    <ul class="navigation-container">
        <li><a href="/pages/home" class="subtitle">home</a></li>
    </ul>

    <div class="button-exit-container">
    <button id="suap-logout-button" class="paragraph"> <i class="fa-solid fa-user-minus"></i> <span class="subtitle">sair</span></button>
    </div>
</nav>

<!-- script que abre e fecha a notificação -->
<script >
    let notify = document.querySelector('.notify')
    let verify = false;
document.getElementById("button-bell").addEventListener('click', () =>{
    verify = !verify
   if(verify){
    notify.style.display = 'flex'
   }
   else{
     notify.style.display = 'none'
   }
})
</script>
<!-- script pra receber os dados do usuario do suap -->
<script>
    function getCookie(name) {
    const cookieArr = document.cookie.split(";"); 
    for (let i = 0; i < cookieArr.length; i++) {
        let cookie = cookieArr[i].trim();  
        if (cookie.startsWith(name + "=")) {
            return cookie.substring(name.length + 1);  
        }
    }
    return null;  
}

const accessToken = getCookie('token');
if (!accessToken) {
    window.location.href = "/";
} else {
    $.ajax({
        url: 'https://suap.ifg.edu.br/api/v2/minhas-informacoes/meus-dados/',
        method: 'GET',
        headers: {
            'Authorization': 'Bearer ' + accessToken, 
            'Accept': 'application/json'
        },
        success: function(data) {
            console.log(data)
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Erro na requisição:', textStatus, errorThrown);
        }
    });
}

function deleteCookie(cookieName) {
    document.cookie = `${cookieName}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
}

$("#suap-logout-button").click(function () {
    deleteCookie('token');
    window.location.href = "/";
});
</script>