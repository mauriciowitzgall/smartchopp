
<?php

include "global.php";
$menuselecionado="chopes";
include "menu.php";

print_r($_POST);

$codigo=$_GET["codigo"];
$nome=mb_convert_case($_POST["nome"], MB_CASE_TITLE, "UTF-8");
$valuni=$_POST["valuni"];
$valuni=str_replace(",", ".", str_replace(".", "", str_replace("R$ ", "", $valuni)));
$descricao=$_POST["descricao"];
$operacao=$_GET["operacao"];

//NÃO mostrar erros e warnings na tela
error_reporting(E_ERROR | E_PARSE);

//Se for CADASTRO novo
if ($operacao==1) {
	$sql="
		INSERT INTO chopes (nome,valunivenda,descricao) VALUES ('$nome','$valuni','$descricao');
	";
	if (!$query=mysql_query($sql)) die("Erro SQL INSERT: ".mysql_error());
} else if ($operacao==2) {
	$sql="
		UPDATE chopes SET nome='$nome',valunivenda='$valuni',descricao='$descricao' WHERE codigo=$codigo
	";
	if (!$query=mysql_query($sql)) die("Erro SQL UPDATE: ".mysql_error());
} else {
	echo "Erro de parametros!";
	exit;
}

header("Location:"."chopes.php");
die();


include("html_rodape.html");

?>