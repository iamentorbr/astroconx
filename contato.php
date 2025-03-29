<?php
$mensagem = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nome = strip_tags($_POST["nome"]);
  $email = strip_tags($_POST["email"]);
  $mensagem_usuario = strip_tags($_POST["mensagem"]);

  $para = "contato@astroconsciente.com";
  $assunto = "Nova mensagem do site AstroConsciente";
  $mensagem_corpo = "Nome: $nome\nE-mail: $email\nMensagem:\n$mensagem_usuario";
  $headers = "From: $email\r\nReply-To: $email";

  if (mail($para, $assunto, $mensagem_corpo, $headers)) {
    $mensagem = "Mensagem enviada com sucesso! 🌟";
  } else {
    $mensagem = "Erro ao enviar a mensagem. Tente novamente mais tarde.";
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contato • AstroConsciente</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      background-color: #f5f0ff;
      font-family: 'Segoe UI', sans-serif;
    }
    main {
      max-width: 600px;
      margin: 2rem auto;
      background: white;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    h1 {
      text-align: center;
      color: #4a0072;
    }
    form {
      margin-top: 1rem;
    }
    label {
      display: block;
      margin-top: 1rem;
      font-weight: bold;
      color: #4a0072;
    }
    input, textarea {
      width: 100%;
      padding: 0.6rem;
      border-radius: 5px;
      border: 1px solid #ccc;
      background-color: #eeeeee;
      color: #333;
      margin-top: 0.3rem;
    }
    button {
      margin-top: 1.5rem;
      padding: 0.8rem 2rem;
      background-color: #6a1bbf;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
    .social {
      text-align: center;
      margin-top: 2rem;
    }
    .social a {
      color: #4a0072;
      margin: 0 1rem;
      text-decoration: none;
    }
    .mensagem {
      text-align: center;
      margin-top: 1rem;
      color: #4a0072;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <main>
    <h1>Entre em Contato</h1>
    <?php if ($mensagem): ?><p class="mensagem"><?php echo $mensagem; ?></p><?php endif; ?>
    <form method="POST" action="">
      <label for="nome">Nome:</label>
      <input type="text" id="nome" name="nome" required>

      <label for="email">E-mail:</label>
      <input type="email" id="email" name="email" required>

      <label for="mensagem">Mensagem:</label>
      <textarea id="mensagem" name="mensagem" rows="5" required></textarea>

      <button type="submit">Enviar</button>
    </form>

    <div class="social">
      <p>Você também pode me encontrar nas redes sociais:</p>
      <a href="#">Instagram</a> | <a href="#">WhatsApp</a>
    </div>
  </main>
</body>
</html>
