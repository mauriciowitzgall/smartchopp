
<?php

include "global.php";
$menuselecionado="atendimentos";
include "menu.php";

print_r($_POST);

$atendimento=$_GET["atendimento"];
$item=$_GET["item"];

if ($atendimento=="") {
	echo "Erro de parametros!";
	exit;
}	

//NÃO mostrar erros e warnings na tela
error_reporting(E_ERROR | E_PARSE);


$sql="
	DELETE FROM atendimentos_creditos WHERE atendimento=$atendimento AND item=$item;
";
if (!$query=mysql_query($sql)) die("Erro SQL DELETE: ".mysql_error());

header("Location:"."atendimentos_creditos.php?codigo=$atendimento");
die();


include("html_rodape.html");

?>