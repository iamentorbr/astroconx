<?php
function normalizar($texto) {
  return strtolower(preg_replace('/[^a-z0-9]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $texto)));
}

$planeta = isset($_GET['planeta']) ? normalizar($_GET['planeta']) : '';
$signo = isset($_GET['signo']) ? normalizar($_GET['signo']) : '';

$arquivo = __DIR__ . "/analises_" . $planeta . "/" . $signo . ".txt";

$conteudo = "";
if (file_exists($arquivo)) {
  $conteudo = file_get_contents($arquivo);
} else {
  $conteudo = "Análise não encontrada para $planeta em $signo. Em breve traremos luz para esse aspecto! ✨";
}

$protocolo_link = "protocolo_" . $planeta . ".html";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Análise Terapêutica</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body { background-color: #f5f0ff; font-family: 'Segoe UI', sans-serif; padding: 2rem; margin: 0; }
    .container { background: white; max-width: 800px; margin: auto; padding: 2rem; border-radius: 12px; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
    h1 { color: #4a0072; }
    pre { white-space: pre-wrap; line-height: 1.6; color: #333; }
    .botao { margin-top: 2rem; display: inline-block; padding: 0.6rem 1.5rem; background: #6a1bbf; color: white; text-decoration: none; border-radius: 8px; }
  </style>
</head>
<body>
  <div class="container">
    <h1>Análise de <?php echo ucfirst($planeta); ?> em <?php echo ucfirst($signo); ?></h1>
    <pre><?php echo $conteudo; ?></pre>
    <a class="botao" href="<?php echo $protocolo_link; ?>">🔮 Acessar Protocolo</a>
    <br><br>
    <a href="dashboard.php" style="color:#4a0072;">← Voltar ao Dashboard</a>
  </div>
</body>
</html>
