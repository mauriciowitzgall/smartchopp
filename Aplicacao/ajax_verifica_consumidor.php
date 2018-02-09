<?php 

include "conexao.php";

$telefone=$_POST["telefone"];
$sql="SELECT codigo,nome FROM consumidores WHERE telefone like '$telefone'";
if (!$query=mysql_query($sql)) die("Erro SQL: ".mysql_error());
$dados=mysql_fetch_assoc($query);	
$linhas=mysql_num_rows($query);
if ($linhas==1) {
	$codigo=$dados["codigo"];
	$nome=$dados["nome"];
	echo "$codigo|$nome";
} else if ($linhas > 1) {
	//echo "Há mais de um consumidor com o mesmo telefone";
	echo "0";
} else {
	echo "0";
}
?>