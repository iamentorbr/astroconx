<?php
session_start();
if (!isset($_SESSION["admin"])) {
  header("Location: login.php");
  exit;
}

$index = isset($_GET["id"]) ? intval($_GET["id"]) : -1;
$produtos = json_decode(file_get_contents("../dados/produtos.json"), true);

if ($index >= 0 && $index < count($produtos)) {
  array_splice($produtos, $index, 1);
  file_put_contents("../dados/produtos.json", json_encode($produtos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}
header("Location: painel.php");
exit;
