<?php
session_start();
if (!isset($_SESSION["admin"])) {
  header("Location: login.php");
  exit;
}

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $novo_produto = [
    "titulo" => $_POST["titulo"],
    "categoria" => $_POST["categoria"],
    "descricao" => $_POST["descricao"],
    "valor" => $_POST["valor"],
    "imagem" => $_POST["imagem"],
    "link_pagamento" => $_POST["link_pagamento"],
    "data" => date("Y-m-d")
  ];

  $produtos = json_decode(file_get_contents("../dados/produtos.json"), true);
  $produtos[] = $novo_produto;

  file_put_contents("../dados/produtos.json", json_encode($produtos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
  $mensagem = "Produto cadastrado com sucesso!";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Novo Produto</title>
  <style>
    body { background-color: #f5f0ff; font-family: 'Segoe UI', sans-serif; padding: 2rem; }
    form {
      max-width: 600px; margin: auto; background: white; padding: 2rem;
      border-radius: 12px; box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    label { display: block; margin-top: 1rem; font-weight: bold; color: #4a0072; }
    input, textarea, select {
      width: 100%; padding: 0.6rem; border-radius: 6px;
      border: 1px solid #ccc; background-color: #eeeeee; color: #333;
      margin-top: 0.3rem;
    }
    button {
      margin-top: 1.5rem; padding: 0.7rem 2rem;
      background-color: #6a1bbf; color: white; border: none; border-radius: 6px; cursor: pointer;
    }
    .mensagem { text-align: center; color: green; margin-bottom: 1rem; }
    .voltar { text-align:center; margin-top:2rem; }
    .voltar a { color:#4a0072; text-decoration: none; }
  </style>
</head>
<body>
  <h2 style="text-align:center;">Adicionar Produto</h2>
  <?php if ($mensagem): ?><p class="mensagem"><?php echo $mensagem; ?></p><?php endif; ?>
  <form method="POST">
    <label>Título:</label>
    <input type="text" name="titulo" required>
    <label>Categoria:</label>
    <select name="categoria">
      <option value="protocolo">Protocolo</option>
      <option value="ebook">E-book</option>
      <option value="curso">Curso</option>
    </select>
    <label>Descrição:</label>
    <textarea name="descricao" rows="3" required></textarea>
    <label>Valor:</label>
    <input type="text" name="valor" required>
    <label>Imagem (URL):</label>
    <input type="text" name="imagem" required>
    <label>Link de Pagamento:</label>
    <input type="text" name="link_pagamento" required>
    <button type="submit">Salvar</button>
  </form>
  <div class="voltar">
    <a href="painel.php">← Voltar para o Painel</a>
  </div>
</body>
</html>
