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
    // Fazer a requisição com jQuery usando o token
    $.ajax({
        url: 'https://suap.ifg.edu.br/api/v2/minhas-informacoes/meus-dados/',
        method: 'GET',
        headers: {
            'Authorization': 'Bearer ' + accessToken, 
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

function deleteCookie(cookieName) {
    document.cookie = `${cookieName}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
}

$("#suap-logout-button").click(function () {
    deleteCookie('token');
    window.location.href = "/";
});