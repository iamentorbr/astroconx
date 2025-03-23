
document.getElementById("mapaForm").addEventListener("submit", async function (e) {
  e.preventDefault();

  const dados = {
    nome: document.getElementById("nome").value,
    email: document.getElementById("email").value,
    whatsapp: document.getElementById("whatsapp").value,
    sol: document.getElementById("sol").value,
    lua: document.getElementById("lua").value,
    ascendente: document.getElementById("ascendente").value,
    venus: document.getElementById("venus").value,
    marte: document.getElementById("marte").value,
    mercurio: document.getElementById("mercurio").value,
    saturno: document.getElementById("saturno").value,
    mc: document.getElementById("mc").value
  };

  try {
    const resposta = await fetch("http://localhost:3001/api/cadastro", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(dados)
    });

    const resultado = await resposta.json();
    if (resposta.ok) {
      alert("🌟 Cadastro enviado com sucesso!");
      document.getElementById("mapaForm").reset();
    } else {
      alert("Erro: " + resultado.erro);
    }
  } catch (erro) {
    console.error("Erro ao enviar:", erro);
    alert("Erro na conexão com o servidor.");
  }
});
