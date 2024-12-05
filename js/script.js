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
  const url = "https://suap.ifg.edu.br/api/autenticacao/token/";
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
    console.log(json)
    // window.location.href = "/pages/home";
    setCookie('token',json.token,24)
  } catch (error) {
    console.error("Erro ao autenticar:", error.message);
    alert("Falha ao realizar login. Verifique suas credenciais.");
  }
}

// function setCookie(name, value, hours = 24) {
//   const date = new Date();
//   date.setTime(date.getTime() + hours * 60 * 60 * 1000);
//   const expires = "expires=" + date.toUTCString();
//   document.cookie = `${name}=${encodeURIComponent(value)}; ${expires}; path=/`;
// }

fetch('https://suap.ifg.edu.br/api/v2/minhas-informacoes/meus-dados/', {
  method: 'GET',
  headers: {
    'Content-Type': 'application/json',
  },
  credentials: 'include',  // Isso permite o envio do cookie de sessão
})
  .then(response => response.json())
  .then(data => console.log(data))
  .catch(error => console.error('Erro ao acessar dados:', error));

