<?php
session_start();
if (!isset($_SESSION["admin"])) {
  header("Location: login.php");
  exit;
}

$produtos = json_decode(file_get_contents("../dados/produtos.json"), true);
$index = isset($_GET["id"]) ? intval($_GET["id"]) : -1;
$mensagem = "";

if ($index < 0 || $index >= count($produtos)) {
  die("Produto não encontrado.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $produtos[$index] = [
    "titulo" => $_POST["titulo"],
    "categoria" => $_POST["categoria"],
    "descricao" => $_POST["descricao"],
    "valor" => $_POST["valor"],
    "imagem" => $_POST["imagem"],
    "link_pagamento" => $_POST["link_pagamento"]
  ];

  file_put_contents("../dados/produtos.json", json_encode($produtos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
  $mensagem = "Produto atualizado com sucesso!";
}

$produto = $produtos[$index];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Editar Produto</title>
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
  </style>
</head>
<body>
  <h2 style="text-align:center;">Editar Produto</h2>
  <?php if ($mensagem): ?><p class="mensagem"><?php echo $mensagem; ?></p><?php endif; ?>
  <form method="POST">
    <label>Título:</label>
    <input type="text" name="titulo" value="<?php echo $produto['titulo']; ?>" required>
    <label>Categoria:</label>
    <select name="categoria">
      <option value="protocolo" <?php if ($produto['categoria']=='protocolo') echo 'selected'; ?>>Protocolo</option>
      <option value="ebook" <?php if ($produto['categoria']=='ebook') echo 'selected'; ?>>E-book</option>
      <option value="curso" <?php if ($produto['categoria']=='curso') echo 'selected'; ?>>Curso</option>
    </select>
    <label>Descrição:</label>
    <textarea name="descricao" rows="3" required><?php echo $produto['descricao']; ?></textarea>
    <label>Valor:</label>
    <input type="text" name="valor" value="<?php echo $produto['valor']; ?>" required>
    <label>Imagem:</label>
    <input type="text" name="imagem" value="<?php echo $produto['imagem']; ?>" required>
    <label>Link de Pagamento:</label>
    <input type="text" name="link_pagamento" value="<?php echo $produto['link_pagamento']; ?>" required>
    <button type="submit">Atualizar</button>
  </form>
</body>
</html>
