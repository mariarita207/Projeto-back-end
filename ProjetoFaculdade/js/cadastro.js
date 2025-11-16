//Validação de CPF (e outras functions)
function validarCPF(cpf) {
  cpf = cpf.replace(/[^\d]+/g, ''); // Remove caracteres não numéricos

  if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) return false;

  let soma = 0;
  for (let i = 0; i < 9; i++) {
    soma += parseInt(cpf.charAt(i)) * (10 - i);
  }

  let resto = 11 - (soma % 11);
  let digito1 = resto >= 10 ? 0 : resto;

  soma = 0;
  for (let i = 0; i < 10; i++) {
    soma += parseInt(cpf.charAt(i)) * (11 - i);
  }

  resto = 11 - (soma % 11);
  let digito2 = resto >= 10 ? 0 : resto;

  return Number(cpf.charAt(9)) === digito1 && Number(cpf.charAt(10)) === digito2; //antes estava return cpf.charAt(9) == digito1 && cpf.charAt(10) == digito2;
}

    // Função para mostrar erro
    function mostrarErro(texto) {
      const mensagem = document.getElementById("mensagem");
        mensagem.innerHTML = `<div class="alert alert-danger">${texto}</div>`;
  }

  // Função para mostrar sucesso
    function mostrarSucesso(texto) {
      const mensagem = document.getElementById("mensagem");
        mensagem.innerHTML = `<div class="alert alert-success">${texto}</div>`;
  }  

  //Função para marcar campo com erro ou sucesso
  function marcarCampo(campoId, erro, mensagem = "") {
  const campo = document.getElementById(campoId);

  // Remove mensagens antigas
  document.querySelectorAll(`#${campoId} ~ small.erro-inline`).forEach(el => el.remove());

  if (erro) {
    campo.classList.add("input-erro");
    campo.classList.remove("input-sucesso");

    // Cria mensagem de erro
    const small = document.createElement("small");
    small.className = "erro-inline text-danger";
    small.style.fontSize = "11px";
    small.textContent = mensagem;
    campo.insertAdjacentElement("afterend", small);
  } else {
    campo.classList.remove("input-erro");
    campo.classList.add("input-sucesso");
  }
}

    // Evento de envio do formulário
    document.getElementById("formCadastro").addEventListener("submit", function (e) {
    const nome = document.getElementById("nome").value.trim();
    const dataNascimento = new Date(document.getElementById("data").value);
    const dataMinima = new Date("1900-01-01");
    const hoje = new Date();
    const data_nascimento = document.getElementById("data").value;
    const sexo = document.getElementById("sexo").value;
    const opcoesValidas = ["Masculino", "Feminino", "Outro"];
    const mae = document.getElementById("mae").value.trim();
    const email = document.getElementById("email").value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const cpf = document.getElementById("cpf").value.trim();
    const telefoneRegex = /^(\+?55\s?\(?\d{2}\)?\s?|\(?\d{2}\)?\s?)\d{4,5}\-?\d{4}$/;
    const cep = document.getElementById("cep").value.trim();
    const telefoneCelular = document.getElementById("telefoneCelular").value.trim();
    const endereco = document.getElementById("endereco").value.trim();
    const login = document.getElementById("login").value.trim();
    const senha = document.getElementById("senha").value.trim();
    const confirmarSenha = document.getElementById("confirmarSenha").value.trim();
    const mensagem = document.getElementById("mensagem");

    // Limpa mensagens anteriores
    mensagem.innerHTML = "";

    // Limpa mensagens inline antigas
    document.querySelectorAll(".erro-inline").forEach(el => el.remove());

    // Verifica se todos os campos estão preenchidos
    let campos = ["nome", "data", "sexo", "mae", "cpf", "cep", "telefoneCelular", "endereco", "login", "senha", "confirmarSenha"];
    let camposVazios = campos.filter(id => !document.getElementById(id).value.trim());
    if (camposVazios.length > 0) {
      camposVazios.forEach(id => marcarCampo(id, true, "Campo obrigatório."));
        mostrarErro("Todos os campos são obrigatórios.");
          return;
}
    
    // Validação de nome
    if (nome.length < 15 || nome.length > 60 || !/^[a-zA-ZÀ-ú\s]+$/.test(nome)) {
      marcarCampo("nome", true, "O nome deve ter entre 15 e 60 caracteres alfabéticos.");
      return;
    } else {
      marcarCampo("nome", false);
    }

    // Validação de data de nascimento
  if (dataNascimento < dataMinima || dataNascimento > hoje) {
    marcarCampo("data", true, "Por favor, informe uma data de nascimento válida.");
      return;
} else {
      marcarCampo("data", false);
    }

//Validação de sexo
  if (!opcoesValidas.includes(sexo)) {
    marcarCampo("sexo", true, "Por favor, selecione uma opção válida para o sexo.");
      return;
} else {
      marcarCampo("sexo", false);
    }

//Validação de nome da mãe
    if (mae.length < 5 || mae.length > 60 || !/^[a-zA-ZÀ-ú\s]+$/.test(mae)) {
      marcarCampo("mae", true, "O nome materno deve ter entre 5 e 60 caracteres apenas com letras.");
        return;
} else {
      marcarCampo("mae", false);
    }

//validação de email
  if (!emailRegex.test(email)) {
    marcarCampo("email", true, "Por favor, insira um e-mail válido.");
      return;
} else {
      marcarCampo("email", false);
    }

//Validação de telefoneCelular
    if (!telefoneRegex.test(telefoneCelular)) {
  marcarCampo("telefoneCelular",true, "Telefone celular deve estar no formato (+55)XX-XXXXXXXX.");
  return;
} else {
      marcarCampo("telefoneCelular", false);
    }

/// Validação de CEP
const cepRegex = /^\d{5}-?\d{3}$/;
if (!cepRegex.test(cep)) {
  marcarCampo("cep", true, "CEP deve estar no formato XXXXX-XXX.");
  return;
} else {
  marcarCampo("cep", false);
}

if (!validarCPF(cpf)) {
  marcarCampo("cpf", true, "CPF inválido.");
  return;
} else {
      marcarCampo("cpf", false);
    }

// Validação de endereço
if (endereco.length < 10 || endereco.length > 100) {
  marcarCampo("endereco", true, "O endereço deve ter entre 10 e 100 caracteres.");
  return;
} else {
      marcarCampo("endereco", false);
    }

// Validação de login
  if (!/^[a-zA-Z]{6}$/.test(login)) {
    marcarCampo("login", true, "O login deve conter exatamente 6 letras, sem números ou símbolos.");
      return;
} else {
      marcarCampo("login", false);
    }

    // Validação de senha
    if (!/^[a-zA-Z]{8}$/.test(senha)) {
      marcarCampo("senha", true, "A senha deve conter exatamente 8 letras.");
      return;
    }

    // Validação de confirmação de senha
    if (senha !== confirmarSenha) {
      marcarCampo("confirmarSenha", true, "As senhas não coincidem.");
      return;
    } else {
      marcarCampo("confirmarSenha", false);
    }

    /// MULTI-USUÁRIOS: carrega lista ou cria nova
    let usuarios = JSON.parse(localStorage.getItem("usuarios")) || [];

    if (usuarios.some(u => u.email === email)) {
      marcarCampo("email", true, "Este e-mail já está cadastrado.");
      return;
    } else {
      marcarCampo("email", false);
    }

    if (usuarios.some(u => u.cpf === cpf)) {
      marcarCampo("cpf", true, "Este CPF já está cadastrado.");
      return;
    } else {
      marcarCampo("cpf", false);
    }

    // Adiciona o novo usuário
    usuarios.push({
      nome, dataNascimento: data_nascimento, sexo, mae,
      email, cpf, cep, telefoneCelular, endereco,
      login, senha
    });

    // Salva de volta
    localStorage.setItem("usuarios", JSON.stringify(usuarios));
    localStorage.setItem("ultimoLogin", login);

    mostrarSucesso("Cadastro realizado com sucesso! Redirecionando...");
    // Limpa o formulário
    document.getElementById("formCadastro").reset();
    // Desabilita o botão (opcional, para impedir duplo envio)
    document.getElementById("botao").disabled = true;
    // Redireciona para tela de login após 2 segundos
    setTimeout(() => {
      window.location.href = "login.html";
    }, 2000);
  });
  
    
// Função para buscar endereço automaticamente via CEP usando BrasilAPI
async function buscarEndereco(cep) {
  const cepLimpo = cep.replace(/\D/g, ''); // Remove tudo que não for número
  if (cepLimpo.length !== 8) {
    marcarCampo("cep", true, "CEP inválido.");
    return;
  }

  try {
    const resposta = await fetch(`https://brasilapi.com.br/api/cep/v2/${cepLimpo}`);
    if (!resposta.ok) {
      marcarCampo("cep", true, "CEP não encontrado.");
      return;
    }
    const dados = await resposta.json();

    // Preenche o endereço automaticamente
    const enderecoCompleto = `${dados.street}, ${dados.neighborhood}, ${dados.city} - ${dados.state}`;
    document.getElementById("endereco").value = enderecoCompleto;
    marcarCampo("cep", false);

  } catch (erro) {
    console.error("Erro ao buscar CEP:", erro);
    marcarCampo("cep", true, "Erro ao buscar CEP.");
  }
}

// Evento: quando o usuário sai do campo CEP
document.getElementById("cep").addEventListener("blur", function() {
  buscarEndereco(this.value);
});

let trilho = document.getElementById('trilho')
let body = document.querySelector('body')


trilho.addEventListener('click', ()=>{
trilho.classList.toggle('dark')
body.classList.toggle('dark')

 // Salva o estado no localStorage
if (body.classList.contains('dark')) {
        localStorage.setItem('theme', 'dark');
    } else {
        localStorage.setItem('theme', 'light');
    }

})

// Ao carregar a página, aplica o tema salvo
window.addEventListener('DOMContentLoaded', () => {
    const savedTheme = localStorage.getItem('theme');
    
    if (savedTheme === 'dark') {
        document.body.classList.add('dark');
        document.getElementById('trilho').classList.add('dark');
    }
});
