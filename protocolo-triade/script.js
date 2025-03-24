
function toggleDia(id) {
  const content = document.getElementById(id);
  content.style.display = content.style.display === 'block' ? 'none' : 'block';
}
function concluirDia(semana, proxId) {
  localStorage.setItem('semana-' + semana, 'true');
  document.getElementById(proxId).style.display = 'block';
}
function salvarDiario(id) {
  const val = document.getElementById('diario-' + id).value;
  localStorage.setItem('diario-' + id, val);
}
function carregarDiarios() {
  for (let i = 1; i <= 4; i++) {
    const val = localStorage.getItem('diario-semana' + i);
    if (val) document.getElementById('diario-semana' + i).value = val;
  }
}
window.onload = function() {
  carregarDiarios();
  for (let i = 2; i <= 4; i++) {
    if (localStorage.getItem('semana-' + (i - 1)) === 'true') {
      document.getElementById('semana' + i).style.display = 'block';
    } else {
      document.getElementById('semana' + i).style.display = 'none';
    }
  }
}
