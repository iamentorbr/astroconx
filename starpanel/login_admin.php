<?php
session_start();

$email_padrao = "contato.manifa@gmail.com";
$senha_padrao = "astroadmin2025";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = $_POST["email"];
  $senha = $_POST["senha"];

  if ($email === $email_padrao && $senha === $senha_padrao) {
    $_SESSION["admin"] = true;
    header("Location: painel.php");
    exit;
  } else {
    $erro = "E-mail ou senha inválidos.";
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Login Admin • AstroConsciente</title>
  <style>
    body {
      background-color: #f5f0ff;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .login {
      background: white;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      max-width: 400px;
      width: 100%;
      text-align: center;
    }
    h2 {
      color: #4a0072;
    }
    label {
      display: block;
      margin-top: 1rem;
      font-weight: bold;
      color: #4a0072;
      text-align: left;
    }
    input {
      width: 100%;
      padding: 0.6rem;
      margin-top: 0.3rem;
      border-radius: 6px;
      border: 1px solid #ccc;
      background-color: #eeeeee;
    }
    button {
      margin-top: 1.5rem;
      width: 100%;
      padding: 0.7rem;
      background-color: #6a1bbf;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
    .erro {
      color: red;
      margin-top: 1rem;
    }
    .logo {
      font-size: 1.2rem;
      margin-bottom: 1rem;
      color: #6a1bbf;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="login">
    <div class="logo">🔐 Painel Administrativo AstroConsciente</div>
    <h2>Login</h2>
    <?php if (isset($erro)) echo "<p class='erro'>$erro</p>"; ?>
    <form method="POST">
      <label for="email">E-mail:</label>
      <input type="email" name="email" id="email" required>

      <label for="senha">Senha:</label>
      <input type="password" name="senha" id="senha" required>

      <button type="submit">Entrar</button>
    </form>
  </div>
</body>
</html>
