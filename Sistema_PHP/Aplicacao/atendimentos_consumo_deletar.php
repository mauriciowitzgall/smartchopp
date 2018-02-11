
<?php

include "global.php";
$menuselecionado="atendimentos";
include "menu.php";

//print_r($_POST);

$atendimento=$_GET["atendimento"];
$item=$_GET["item"];

if (($atendimento=="")||($item=="")) {
	echo "Erro de parametros!";
	exit;
}	

//NÃO mostrar erros e warnings na tela
error_reporting(E_ERROR | E_PARSE);

 $sql="SELECT ai.quantidade as quantidade_consumo, cpr.codigo as chopeira_codigo FROM chopeiras cpr JOIN atendimentos_itens ai on (ai.chopeira_codigo=cpr.codigo) WHERE ai.atendimento=$atendimento AND ai.item=$item";
if (!$query=mysql_query($sql)) die("Erro de SQL".mysql_error());
$dados=mysql_fetch_assoc($query);
$quantidade_consumo=$dados["quantidade_consumo"];
$chopeira=$dados["chopeira_codigo"];


//Atualizar quantidade atual da chopeira
 $sql="UPDATE chopeiras SET quantidade=quantidade+$quantidade_consumo WHERE codigo=$chopeira";
if (!$query=mysql_query($sql)) die("Erro de SQL ao atualizar quantidade da chopeira! ".mysql_error());

//Excluir
 $sql="DELETE FROM atendimentos_itens WHERE atendimento=$atendimento AND item=$item";
if (!$query=mysql_query($sql)) die("Erro SQL DELETE: ".mysql_error());

header("Location:"."atendimentos_consumo.php?codigo=$atendimento");
die();

include("html_rodape.html");

?>