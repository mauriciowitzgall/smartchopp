<?php 

include "conexao.php";

$consumidor=$_POST["consumidor"];

$sql="SELECT * FROM atendimentos where consumidor=$consumidor and situacao=0 and modalidade=1 ORDER BY codigo DESC LIMIT 1";
if (!$query=mysql_query($sql)) die("Erro SQL: ".mysql_error());
$dados=mysql_fetch_assoc($query);
$saldoanterior=$dados["saldo_diferenca"];
echo "$saldoanterior";
?>