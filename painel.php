<?php
session_start();
if (!isset($_SESSION["admin"])) {
  header("Location: login.php");
  exit;
}

function filtrar_por_periodo($produtos, $periodo) {
  $hoje = date("Y-m-d");
  $ano_atual = date("Y");
  $mes_atual = date("Y-m");

  return array_filter($produtos, function($p) use ($periodo, $hoje, $ano_atual, $mes_atual) {
    if (!isset($p["data"])) return $periodo == "todos";
    $data = $p["data"];
    return $periodo == "todos"
      || ($periodo == "hoje" && $data == $hoje)
      || ($periodo == "mes" && strpos($data, $mes_atual) === 0)
      || ($periodo == "ano" && strpos($data, $ano_atual) === 0);
  });
}

$produtos = json_decode(file_get_contents("../dados/produtos.json"), true);
$periodo = $_GET["periodo"] ?? "todos";
$produtos_filtrados = filtrar_por_periodo($produtos, $periodo);

$total = count($produtos_filtrados);
$categorias = ["protocolo" => 0, "ebook" => 0, "curso" => 0];
$total_pago = 0;
$total_gratuito = 0;

$vp = $ve = $vc = 0;

foreach ($produtos_filtrados as $p) {
  $cat = $p["categoria"];
  if (isset($categorias[$cat])) $categorias[$cat]++;
  $valor = strtolower($p["valor"]);
  if (strpos($valor, "r$") !== false) {
    $n = floatval(str_replace([",", "r$", " "], ["", "", ""], $valor));
    $total_pago += $n;
    if ($cat == "protocolo") $vp += $n;
    if ($cat == "ebook") $ve += $n;
    if ($cat == "curso") $vc += $n;
  } else {
    $total_gratuito++;
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Painel Inteligente</title>
  
  <style>
    body { background-color: #f5f0ff; font-family: 'Segoe UI', sans-serif; padding: 2rem; }
    h1, h2 { color: #4a0072; text-align: center; }
    .filtros { text-align: center; margin-bottom: 1rem; }
    .filtros select { padding: 0.5rem; font-size: 1rem; }
    .resumo { display: flex; justify-content: space-around; margin: 2rem 0; gap: 1rem; flex-wrap: wrap; }
    .box { background: white; padding: 1.2rem; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.08); min-width: 180px; text-align: center; }
    .box strong { font-size: 1.5rem; display: block; margin-top: 0.3rem; }
    table { width: 100%; border-collapse: collapse; margin-top: 2rem; }
    th, td { padding: 0.8rem; border-bottom: 1px solid #ccc; text-align: left; }
    th { background-color: #eee; color: #4a0072; }
    .novo { display: block; margin: 1rem auto; background: #6a1bbf; color: white; padding: 0.7rem 1.5rem; border-radius: 8px; text-decoration: none; width: fit-content; text-align: center; }
    .acoes a { margin-right: 1rem; color: #4a0072; text-decoration: underline; }
  </style>
</head>
<body>
<h1>Painel de Performance</h1>

<div class="filtros">
  <form method="GET">
    <label for="periodo">Filtrar por período:</label>
    <select name="periodo" onchange="this.form.submit()">
      <option value="todos" <?= $periodo=='todos'?'selected':'' ?>>Todos</option>
      <option value="hoje" <?= $periodo=='hoje'?'selected':'' ?>>Hoje</option>
      <option value="mes" <?= $periodo=='mes'?'selected':'' ?>>Este mês</option>
      <option value="ano" <?= $periodo=='ano'?'selected':'' ?>>Este ano</option>
    </select>
  </form>
</div>

<div class="resumo">
  <div class="box">Total de Produtos<strong><?= $total ?></strong></div>
  <div class="box">Protocolos<strong><?= $categorias['protocolo'] ?></strong></div>
  <div class="box">E-books<strong><?= $categorias['ebook'] ?></strong></div>
  <div class="box">Cursos<strong><?= $categorias['curso'] ?></strong></div>
  <div class="box">Gratuitos<strong><?= $total_gratuito ?></strong></div>
  <div class="box">R$ Vendido<strong>R$ <?= number_format($total_pago, 2, ",", ".") ?></strong></div>
</div>



<a class="novo" href="novo.php">➕ Adicionar Produto</a>

<table>
  <thead>
    <tr><th>Título</th><th>Categoria</th><th>Valor</th><th>Data</th><th>Ações</th></tr>
  </thead>
  <tbody>
    <?php foreach ($produtos_filtrados as $i => $p): ?>
    <tr>
      <td><?= $p["titulo"] ?></td>
      <td><?= ucfirst($p["categoria"]) ?></td>
      <td><?= $p["valor"] ?></td>
      <td><?= $p["data"] ?? "" ?></td>
      <td class="acoes">
        <a href="editar.php?id=<?= $i ?>">Editar</a>
        <a href="remover.php?id=<?= $i ?>" onclick="return confirm('Deseja remover?')">Remover</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<script>
  new Chart(document.getElementById("graficoCategorias"), {
    type: "pie",
    data: {
      labels: ["Protocolos", "E-books", "Cursos"],
      datasets: [{
        data: [<?= $categorias["protocolo"] ?>, <?= $categorias["ebook"] ?>, <?= $categorias["curso"] ?>],
        backgroundColor: ["#8e24aa", "#3949ab", "#00acc1"]
      }]
    }
  });

  new Chart(document.getElementById("graficoFaturamento"), {
    type: "bar",
    data: {
      labels: ["Protocolos", "E-books", "Cursos"],
      datasets: [{
        label: "Faturamento (R$)",
        data: [<?= $vp ?>, <?= $ve ?>, <?= $vc ?>],
        backgroundColor: ["#8e24aa", "#3949ab", "#00acc1"]
      }]
    },
    options: { scales: { y: { beginAtZero: true } } }
  });
</script>
</body>
</html>
