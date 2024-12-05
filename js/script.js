const form = document
  .querySelector(".login-form")
  .addEventListener("submit", (e) => {
    e.preventDefault();
    const login = document.querySelector("#login").value;
    const password = document.querySelector("#password").value;

    if (login && password) {
      Logar(login, password);
      
    } else {
      alert("Login inválido!!!");
    }
    
  });

async function Logar(login, password) {
  const url = "https://suap.ifg.edu.br/api/v2/autenticacao/token/";
  try {
    const response = await fetch(url, {
      method: "POST",
      headers: {
        "Accept": "application/json",
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        username: login,
        password: password,
      }),
    });

    if (!response.ok) {
      throw new Error(`Erro ao autenticar: ${response.status}`);
    }

    const json = await response.json();
    setCookie('token',json.access,24)
    window.location.href = "/pages/home";
  } catch (error) {
    console.error("Erro ao autenticar:", error.message);
    alert("Falha ao realizar login. Verifique suas credenciais.");
  }
}

function setCookie(name, value, hours = 24) {
  const date = new Date();
  date.setTime(date.getTime() + hours * 60 * 60 * 1000);
  const expires = "expires=" + date.toUTCString();
  document.cookie = `${name}=${encodeURIComponent(value)}; ${expires}; path=/`;
}
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


const verifyToken = async (token) =>{
  const url = 'https://suap.ifg.edu.br/api/v2/autenticacao/token/verify/';
  try {
    const response = await fetch(url, {
      method: "POST",
      headers: {
        "Accept": "application/json",
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        "token": token
      }),
    });

    if (!response.ok) {
      throw new Error(`Erro ao autenticar: ${response.body}`);
    }

    const json = await response.json();
    console.log(json)
    window.location.href = "/pages/home";
  } catch (error) {
    console.error("Erro ao autenticar:", error.message);
    console.log(getCookie('token'))
  }
  
}

if(getCookie('token')){
  verifyToken(getCookie('token'))
}




