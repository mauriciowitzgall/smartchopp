
<?php

include "global.php";
$menuselecionado="chopeiras";
include "menu.php";

//print_r($_POST);

$codigo=$_GET["codigo"];
$nome=$_POST["nome"];
$capacidade=str_replace(",", ".", str_replace(".", "", str_replace("", "", $_POST["capacidade"])));
$quantidade=str_replace(",", ".", str_replace(".", "", str_replace("", "", $_POST["quantidade"])));
$chope=$_POST["chope"];
$equipamento=$_POST["equipamento"];
$operacao=$_GET["operacao"];

//NÃO mostrar erros e warnings na tela
error_reporting(E_ERROR | E_PARSE);

//Se for CADASTRO novo
if ($operacao==1) {
	$sql="
		INSERT INTO chopeiras (nome,capacidade,quantidade,chope,equipamento) VALUES ('$nome','$capacidade','$quantidade','$chope','$equipamento');
	";
	if (!$query=mysql_query($sql)) die("Erro SQL INSERT: ".mysql_error());
} else if ($operacao==2) {
	$sql="
		UPDATE chopeiras SET nome='$nome',capacidade='$capacidade',quantidade='$quantidade',chope='$chope',equipamento='$equipamento' WHERE codigo=$codigo
	";
	if (!$query=mysql_query($sql)) die("Erro SQL UPDATE: ".mysql_error());
} else {
	echo "Erro de parametros!";
	exit;
}

header("Location:"."chopeiras.php");
die();


include("html_rodape.html");

?>