<?php
$produtos = json_decode(file_get_contents("dados/produtos.json"), true);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Vitrine • AstroConsciente</title>
  <style>
    body { background-color: #f5f0ff; font-family: 'Segoe UI', sans-serif; margin: 0; padding: 0; }
    header { background-color: #4a0072; color: white; text-align: center; padding: 2rem 1rem; }
    header h1 { margin: 0; font-size: 2rem; }
    .filtros { text-align: center; margin: 1.5rem; }
    .filtros button { background: #6a1bbf; color: white; border: none; padding: 0.5rem 1rem; margin: 0 0.3rem; border-radius: 6px; cursor: pointer; }
    .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; max-width: 1000px; margin: auto; padding: 2rem; }
    .card { background: white; border-radius: 12px; box-shadow: 0 0 20px rgba(0,0,0,0.08); overflow: hidden; display: flex; flex-direction: column; }
    .card img { width: 100%; height: 180px; object-fit: cover; }
    .card-content { padding: 1rem; flex: 1; }
    .card-content h2 { color: #4a0072; margin-bottom: 0.5rem; }
    .card-content p { margin: 0.5rem 0; font-size: 0.95rem; }
    .valor { font-weight: bold; margin-top: 0.5rem; }
    .botao { display: block; margin: 1rem auto; padding: 0.6rem 1.2rem; background-color: #6a1bbf; color: white; text-align: center; text-decoration: none; border-radius: 8px; width: fit-content; }
    footer { background-color: #4a0072; color: white; text-align: center; padding: 1rem; margin-top: 3rem; }
  </style>
  <script>
    function filtrar(categoria) {
      const cards = document.querySelectorAll('.card');
      cards.forEach(card => {
        card.style.display = (categoria === 'todos' || card.dataset.categoria === categoria) ? 'flex' : 'none';
      });
    }
  </script>
</head>
<body>
  <header>
    <h1>🌟 Vitrine AstroConsciente</h1>
    <p>Protocolos, E-books e Cursos para sua jornada</p>
  </header>
  <div class="filtros">
    <button onclick="filtrar('todos')">Todos</button>
    <button onclick="filtrar('protocolo')">Protocolos</button>
    <button onclick="filtrar('ebook')">E-books</button>
    <button onclick="filtrar('curso')">Cursos</button>
  </div>
  <div class="grid">
    <?php foreach ($produtos as $produto): ?>
    <div class="card" data-categoria="<?php echo $produto['categoria']; ?>">
      <img src="<?php echo $produto['imagem']; ?>" alt="<?php echo $produto['titulo']; ?>">
      <div class="card-content">
        <h2><?php echo $produto['titulo']; ?></h2>
        <p><?php echo $produto['descricao']; ?></p>
        <p class="valor"><?php echo $produto['valor']; ?></p>
      </div>
      <a href="<?php echo $produto['link_pagamento']; ?>" class="botao" target="_blank">Comprar</a>
    </div>
    <?php endforeach; ?>
  </div>
  <footer>
    <p>&copy; 2025 Despertar Astroconsciente. Todos os direitos reservados.</p>
  </footer>
</body>
</html>
