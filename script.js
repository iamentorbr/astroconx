document.addEventListener('DOMContentLoaded', function () {
  const form = document.querySelector('.formulario');
  if (form) {
    form.addEventListener('submit', function (event) {
      event.preventDefault();
      const nome = document.getElementById('nome').value;
      const data = document.getElementById('data').value;
      const hora = document.getElementById('hora').value;
      const cidade = document.getElementById('cidade').value;

      const resultado = document.createElement('div');
      resultado.classList.add('resultado');
      resultado.innerHTML = `
        <h2>🌟 Mapa gerado com sucesso!</h2>
        <p><strong>Nome:</strong> ${nome}</p>
        <p><strong>Data de nascimento:</strong> ${data}</p>
        <p><strong>Hora de nascimento:</strong> ${hora}</p>
        <p><strong>Cidade de nascimento:</strong> ${cidade}</p>
        <p>🌌 Sua análise básica será processada em breve...</p>
      `;

      const anterior = document.querySelector('.resultado');
      if (anterior) anterior.remove();

      form.insertAdjacentElement('afterend', resultado);
    });
  }

  // Slider
  const slides = document.querySelectorAll('.slide');
  let slideAtual = 0;

  function mostrarSlide(index) {
    slides.forEach((slide, i) => {
      slide.classList.remove('ativo');
      if (i === index) slide.classList.add('ativo');
    });
  }

  setInterval(() => {
    slideAtual = (slideAtual + 1) % slides.length;
    mostrarSlide(slideAtual);
  }, 4000);
});
