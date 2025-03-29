<?php
session_start();

$host = "mysql.astroconsciente.com";
$usuario = "astroconscient";
$senha = "astro36166255senha";
$banco = "astroconscient";

$conn = new mysqli($host, $usuario, $senha, $banco);
if ($conn->connect_error) {
  die("Erro de conexão: " . $conn->connect_error);
}

$mensagem = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["email"];
  $senha_digitada = $_POST["senha"];

  $sql = "SELECT id, nome, senha FROM usuarios WHERE email = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $resultado = $stmt->get_result();

  if ($resultado->num_rows === 1) {
    $usuario = $resultado->fetch_assoc();
    if (password_verify($senha_digitada, $usuario["senha"])) {
      $_SESSION["usuario_id"] = $usuario["id"];
      $_SESSION["usuario_nome"] = $usuario["nome"];

      // Redirecionar para o dashboard
      header("Location: dashboard.php");
      exit;
    } else {
      $mensagem = "Senha incorreta.";
    }
  } else {
    $mensagem = "Usuário não encontrado.";
  }
  $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Login • AstroConsciente</title>
  <style>
    body { background-color: #f5f0ff; font-family: 'Segoe UI', sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; }
    .login { background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 0 15px rgba(0,0,0,0.1); max-width: 400px; width: 100%; text-align: center; }
    h2 { color: #4a0072; }
    label { display: block; margin-top: 1rem; font-weight: bold; color: #4a0072; text-align: left; }
    input { width: 100%; padding: 0.6rem; margin-top: 0.3rem; border-radius: 6px; border: 1px solid #ccc; background-color: #eeeeee; }
    button { margin-top: 1.5rem; width: 100%; padding: 0.7rem; background-color: #6a1bbf; color: white; border: none; border-radius: 6px; cursor: pointer; }
    .erro { color: red; margin-top: 1rem; }
  </style>
</head>
<body>
  <div class="login">
    <h2>Entrar no Portal</h2>
    <?php if (!empty($mensagem)) echo "<p class='erro'>$mensagem</p>"; ?>
    <form method="POST">
      <label for="email">E-mail:</label>
      <input type="email" name="email" required>
      <label for="senha">Senha:</label>
      <input type="password" name="senha" required>
      <button type="submit">Acessar</button>
    </form>
  </div>
</body>
</html>
