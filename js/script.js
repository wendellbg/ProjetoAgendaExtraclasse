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
    setCookie("token", json.access, 24);

    if (verifyToken(getCookie("token"))) {
      // filtrar os dados que vem do suap que serão utilizados no projeto excluindo os dados sensiveis
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
      // fazendo requisição pro suap
      const accessToken = getCookie("token");
      if (!accessToken) {
        window.location.href = "/";
      } else {
        $.ajax({
          url: "https://suap.ifg.edu.br/api/v2/minhas-informacoes/meus-dados/",
          method: "GET",
          headers: {
            Authorization: "Bearer " + accessToken,
            Accept: "application/json",
          },
          success: function (data) {
            console.log(dataFilter(data));
            saveUserData(dataFilter(data));
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.error("Erro na requisição:", textStatus, errorThrown);
          },
        });
      }

      const saveUserData = (data) => {
        $.ajax({
          url: "/global/data/user.data.php",
          method: "POST",
          data: data,
          success: function (response) {
            window.location.href = "/pages/home";
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.error("Erro ao enviar os dados:", textStatus, errorThrown);
          },
        });
      };
    }
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
const verifyToken = async (token) => {
  const url = "https://suap.ifg.edu.br/api/v2/autenticacao/token/verify/";
  try {
    const response = await fetch(url, {
      method: "POST",
      headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        token: token,
      }),
    });
    if (!response.ok) {
      throw new Error(`Erro ao autenticar: ${response.body}`);
    }
    return true;
  } catch (error) {
    console.error("Erro ao autenticar:", error.message);
    return false;
  }
};
