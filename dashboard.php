<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
  header("Location: login.php");
  exit;
}
$nome_usuario = $_SESSION["nome"];

$host = "mysql.astroconsciente.com";
$usuario = "astroconscient";
$senha = "astro36166255senha";
$banco = "astroconscient";

$conn = new mysqli($host, $usuario, $senha, $banco);
if ($conn->connect_error) {
  die("Erro de conexão: " . $conn->connect_error);
}

$planetas = [];
$usuario_id = $_SESSION["usuario_id"];
$sql = "SELECT * FROM mapas_astrais WHERE usuario_id = ? ORDER BY id DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $planetas = $result->fetch_assoc();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard • AstroConsciente</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    body {
      background-color: #f5f0ff;
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
    }
    header {
      background-color: #4a0072;
      color: white;
      text-align: center;
      padding: 2rem 1rem;
    }
    header h1 {
      margin: 0;
    }
    header h1 a {
      color: white;
      text-decoration: none;
    }
    main {
      padding: 2rem;
      max-width: 1000px;
      margin: auto;
    }
    .grid-planetas {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 1.5rem;
    }
    .box {
      background: white;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      padding: 1.5rem;
      text-align: center;
    }
    .box h3 {
      margin-bottom: 0.5rem;
      color: #4a0072;
    }
    .emoji {
      font-size: 2.5rem;
      margin-bottom: 0.5rem;
    }
    .botao {
      display: inline-block;
      padding: 0.6rem 1.5rem;
      margin-top: 2rem;
      background-color: #6a1bbf;
      color: white;
      text-decoration: none;
      border-radius: 8px;
    }
    footer {
      background-color: #4a0072;
      color: white;
      text-align: center;
      padding: 1rem;
      margin-top: 2rem;
    }
    footer a {
      color: white;
      text-decoration: underline;
    }
  </style>
</head>
<body>

<header>
  <h1><a href="index.html">✨ Despertar Astroconsciente ✨</a></h1>
  <p>Bem-vinda, <?php echo htmlspecialchars($nome_usuario); ?>!</p>
</header>

<main>
<?php if ($planetas): ?>
  <h2 style="text-align:center;">🌌 Seu Mapa Astral</h2>
  <div class="grid-planetas">
    <div class="box"><a href="analise.php?planeta=sol&signo=<?php echo $planetas['sol']; ?>"><div class="emoji">☀️</div></a><h3 style='color:#6a1bbf;font-family:"Georgia",serif;'><?php echo $planetas["sol"]; ?></h3><p>Sol</p></div>
    <div class="box"><a href="analise.php?planeta=lua&signo=<?php echo $planetas['lua']; ?>"><div class="emoji">🌙</div></a><h3 style='color:#6a1bbf;font-family:"Georgia",serif;'><?php echo $planetas["lua"]; ?></h3><p>Lua</p></div>
    <div class="box"><a href="analise.php?planeta=ascendente&signo=<?php echo $planetas['ascendente']; ?>"><div class="emoji">⬆️</div></a><h3 style='color:#6a1bbf;font-family:"Georgia",serif;'><?php echo $planetas["ascendente"]; ?></h3><p>Ascendente</p></div>
    <div class="box"><a href="analise.php?planeta=venus&signo=<?php echo $planetas['venus']; ?>"><div class="emoji">💖</div></a><h3 style='color:#6a1bbf;font-family:"Georgia",serif;'><?php echo $planetas["venus"]; ?></h3><p>Vênus</p></div>
    <div class="box"><a href="analise.php?planeta=marte&signo=<?php echo $planetas['marte']; ?>"><div class="emoji">🔥</div></a><h3 style='color:#6a1bbf;font-family:"Georgia",serif;'><?php echo $planetas["marte"]; ?></h3><p>Marte</p></div>
    <div class="box"><a href="analise.php?planeta=mercurio&signo=<?php echo $planetas['mercurio']; ?>"><div class="emoji">🗣️</div></a><h3 style='color:#6a1bbf;font-family:"Georgia",serif;'><?php echo $planetas["mercurio"]; ?></h3><p>Mercúrio</p></div>
    
    <div class="box"><a href="analise.php?planeta=jupiter&signo=<?php echo $planetas['jupiter']; ?>"><div class="emoji">⚡</div></a><h3 style='color:#6a1bbf;font-family:"Georgia",serif;'><?php echo $planetas["jupiter"]; ?></h3><p>Júpiter</p></div>

<div class="box"><a href="analise.php?planeta=saturno&signo=<?php echo $planetas['saturno']; ?>"><div class="emoji">🪐</div></a><h3 style='color:#6a1bbf;font-family:"Georgia",serif;'><?php echo $planetas["saturno"]; ?></h3><p>Saturno</p></div>
    <div class="box"><a href="analise.php?planeta=meio_ceu&signo=<?php echo $planetas['meio_ceu']; ?>"><div class="emoji">🏔️</div></a><h3 style='color:#6a1bbf;font-family:"Georgia",serif;'><?php echo $planetas["meio_ceu"]; ?></h3><p>Meio do Céu</p></div>
  </div>
<?php else: ?>
  <p style="text-align:center;">Você ainda não cadastrou seu mapa. <a href="formulario_mapa.php">Clique aqui</a> para preencher.</p>
<?php endif; ?>

  <div style="text-align:center;">
    <a class="botao" href="formulario_mapa.php">Editar Mapa</a>
    <a class="botao" href="logout.php">Sair</a>
  </div>
</main>

<footer>
  <p>&copy; 2025 Despertar Astroconsciente. Todos os direitos reservados.</p>
  <p>
    <a href="sobre.html">Sobre</a> |
    <a href="blog.html">Blog</a> |
    <a href="contato.html">Contato</a> |
    <a href="termos.html">Termos de Uso</a>
  </p>
</footer>

</body>
</html>
