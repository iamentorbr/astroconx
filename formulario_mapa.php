<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
  header("Location: login.php");
  exit;
}

$host = "mysql.astroconsciente.com";
$usuario = "astroconscient";
$senha = "astro36166255senha";
$banco = "astroconscient";

$conn = new mysqli($host, $usuario, $senha, $banco);
if ($conn->connect_error) {
  die("Erro de conexão: " . $conn->connect_error);
}

$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $usuario_id = $_SESSION["usuario_id"];
  $data_nasc = $_POST["data_nasc"];
  $hora_nasc = $_POST["hora_nasc"];
  $cidade_nasc = $_POST["cidade_nasc"];
  $sol = $_POST["sol"];
  $lua = $_POST["lua"];
  $ascendente = $_POST["ascendente"];
  $jupiter = $_POST["jupiter"];
  $venus = $_POST["venus"];
  $marte = $_POST["marte"];
  $mercurio = $_POST["mercurio"];
  $saturno = $_POST["saturno"];
  $meio_ceu = $_POST["meio_ceu"];

  $sql = "INSERT INTO mapas_astrais (usuario_id, data_nasc, hora_nasc, cidade_nasc, sol, lua, ascendente, jupiter, venus, marte, mercurio, saturno, meio_ceu)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("issssssssssss", $usuario_id, $data_nasc, $hora_nasc, $cidade_nasc, $sol, $lua, $ascendente, $jupiter, $venus, $marte, $mercurio, $saturno, $meio_ceu);

  if ($stmt->execute()) {
    header("Location: dashboard.php?mapa=ok");
    exit;
  } else {
    $msg = "Erro ao cadastrar: " . $stmt->error;
  }

  $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Cadastro de Mapa Astral</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f5f0ff;
    }
    form {
      max-width: 700px;
      margin: 2rem auto;
      background: white;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    label {
      display: block;
      margin-top: 1rem;
      font-weight: bold;
      color: #4a0072;
    }
    input {
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
  </style>
</head>
<body>
  <form method="POST">
    <h2 style="text-align:center; color:#4a0072;">Cadastro do Mapa Astral</h2>
    <?php if ($msg): ?><p><?php echo $msg; ?></p><?php endif; ?>

    <label>Data de Nascimento:</label>
    <input type="date" name="data_nasc" required>

    <label>Hora de Nascimento:</label>
    <input type="time" name="hora_nasc" required>

    <label>Cidade de Nascimento:</label>
    <input type="text" name="cidade_nasc" required>

    <label>Sol:</label>
    <input type="text" name="sol" required>

    <label>Lua:</label>
    <input type="text" name="lua" required>

    <label>Ascendente:</label>
    <input type="text" name="ascendente" required>

    <label>Júpiter:</label>
    <input type="text" name="jupiter" required>

    <label>Vênus:</label>
    <input type="text" name="venus" required>

    <label>Marte:</label>
    <input type="text" name="marte" required>

    <label>Mercúrio:</label>
    <input type="text" name="mercurio" required>

    <label>Saturno:</label>
    <input type="text" name="saturno" required>

    <label>Meio do Céu:</label>
    <input type="text" name="meio_ceu" required>

    <button type="submit">Salvar Mapa</button>
  </form>
</body>
</html>
