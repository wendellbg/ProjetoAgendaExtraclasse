const form = document
  .querySelector(".login-form")
  .addEventListener("submit", (e) => {
    e.preventDefault();
    const login = document.querySelector("#login").value;
    const password = document.querySelector("#password").value;

    if (login && password) {
      // Logar(login, password);

    } else {
      alert("Login inválido!!!");
    }
  });

async function Logar(login, password) {
  // futuramente fazer login com o banco em php que criaremos após o usuario fizer o login do suap
  const url = "login.php";
  try {
    const response = await fetch(url, {
      method: "POST",
      headers: {
        Accept: "application/json",
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
    // setCookie("token", json.access, 24);

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