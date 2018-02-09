
<?php

include "global.php";
$menuselecionado="atendimentos";
include "menu.php";

print_r($_POST);

$atendimento=$_GET["atendimento"];
$operacao=$_GET["operacao"];
$item=$_GET["item"];
$novocredito=str_replace(",", ".", str_replace(".", "", str_replace("R$ ", "", $_POST["novocredito"])));

//NÃO mostrar erros e warnings na tela
error_reporting(E_ERROR | E_PARSE);

//Se for CADASTRO novo
if ($operacao==1) {
	$sql="
		INSERT INTO atendimentos_creditos (atendimento,valor) VALUES ('$atendimento','$novocredito');
	";
	if (!$query=mysql_query($sql)) die("Erro SQL INSERT: ".mysql_error());
} else if ($operacao==2) {
	$sql="
		UPDATE atendimentos_creditos SET valor='$novocredito' WHERE atendimento=$atendimento AND item=$item
	";
	if (!$query=mysql_query($sql)) die("Erro SQL UPDATE: ".mysql_error());
} else {
	echo "Erro de parametros!";
	exit;
}

header("Location:"."atendimentos_creditos.php?codigo=$atendimento");
die();


include("html_rodape.html");

?>