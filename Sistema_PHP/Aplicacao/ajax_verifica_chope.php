<?php 

include "conexao.php";

$chopeira=$_POST["chopeira"];


$sql="SELECT cho.codigo as codigo, cho.nome as nome, cho.valunivenda as valunivenda FROM chopeiras cpr JOIN chopes cho on (cpr.chope=cho.codigo) WHERE cpr.codigo=$chopeira";
if (!$query=mysql_query($sql)) die("Erro SQL: ".mysql_error());
$dados=mysql_fetch_assoc($query);	
$linhas=mysql_num_rows($query);
if ($linhas==1) {
	$codigo=$dados["codigo"];
	$nome=$dados["nome"];
	$valuni="R$ ".number_format($dados["valunivenda"],2,",","");
	echo "$codigo|$nome|$valuni";
} else if ($linhas > 1) {	
	echo "0";
} else {
	echo "0";
}
?>