<?php
$host = "mysql.astroconsciente.com";
$usuario = "astroconscient";
$senha = "astro36166255senha";
$banco = "astroconscient";

$conn = new mysqli($host, $usuario, $senha, $banco);
if ($conn->connect_error) {
  die("Erro de conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nome = $_POST["nome"];
  $email = $_POST["email"];
  $senha_plana = $_POST["senha"];
  $whatsapp = $_POST["whatsapp"];

  if (empty($senha_plana)) {
    echo "<p style='color:red;'>Por favor, insira uma senha.</p>";
    exit;
  }

  $senha_criptografada = password_hash($senha_plana, PASSWORD_DEFAULT);

  $sql = "INSERT INTO usuarios (nome, email, senha, whatsapp) VALUES (?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssss", $nome, $email, $senha_criptografada, $whatsapp);

  if ($stmt->execute()) {
    $assunto = "Cadastro no Portal AstroConsciente";
    $mensagem = "Olá $nome!\n\nSeu cadastro foi realizado com sucesso.\n\nAcesse o painel para completar seu Mapa Astral: https://astroconsciente.com/login.php\n\nLuz e expansão! ✨";
    $headers = "From: contato@astroconsciente.com\r\nReply-To: contato@astroconsciente.com";

    mail($email, $assunto, $mensagem, $headers);
    echo "<p style='color:green;'>Cadastro realizado! Um e-mail foi enviado para você. ✨</p>";
  } else {
    echo "<p style='color:red;'>Erro ao cadastrar: " . $stmt->error . "</p>";
  }
  $stmt->close();
}
$conn->close();
?>
