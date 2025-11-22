// Script para a página de login
document.querySelector("#botao").addEventListener("click", function(e) {
  e.preventDefault();

  const emailInput = document.getElementById("email").value.trim();
  const senhaInput = document.getElementById("senha").value.trim();

  removeMensagem();

  if (!emailInput || !senhaInput) {
    mostrarMensagem("Por favor, preencha todos os campos.", "erro");
    return;
  }

  const usuarios = JSON.parse(localStorage.getItem("usuarios")) || [];

  const usuarioValido = usuarios.find(user => user.email === emailInput && user.senha === senhaInput);

  if (usuarioValido) {
    // Aqui salva o login (não o nome completo) e a senha
    localStorage.setItem("dadosCadastro", JSON.stringify({
      login: usuarioValido.login || emailInput,
      email: usuarioValido.email,
      nome: usuarioValido.nome || "",
      dataNascimento: usuarioValido.dataNascimento || "",
      senha: usuarioValido.senha // adiciona senha para mostrar no menu
    }));

    localStorage.setItem("ultimoLogin", usuarioValido.login || emailInput);

    mostrarMensagem("Login realizado com sucesso! Redirecionando...", "sucesso");
    setTimeout(() => {
      window.location.href = "/Projeto-back-end-main/index.html";
    }, 2000);
  } else {
    mostrarMensagem("Email ou senha incorretos.", "erro");
  }
});

document.getElementById("limpar").addEventListener("click", function () {
  document.getElementById("email").value = "";
  document.getElementById("senha").value = "";
});

function mostrarMensagem(texto, tipo) {
  const container = document.getElementById("mensagem-login");
  container.textContent = texto;
  container.className = "mensagem-login text-center my-2";
  container.style.padding = "10px";
  container.style.borderRadius = "5px";
  container.style.color = "white";
  container.style.backgroundColor = tipo === "sucesso" ? "#4caf50" : "#f44336";
}



function removeMensagem() {
  const container = document.getElementById("mensagem-login");
  container.textContent = "";
  container.className = ""; // limpa estilos extras
}

