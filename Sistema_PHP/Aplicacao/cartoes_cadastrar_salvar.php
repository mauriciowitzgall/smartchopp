
<?php

include "global.php";
$menuselecionado="cartoes";
include "menu.php";

print_r($_POST);

$codigo=$_GET["codigo"];
$rfid=strtoupper($_POST["rfid"]);
$referencia=$_POST["referencia"];
$operacao=$_GET["operacao"];

//NÃO mostrar erros e warnings na tela
error_reporting(E_ERROR | E_PARSE);

//Se for CADASTRO novo
if ($operacao==1) {
	$sql="
		INSERT INTO cartoes (rfid,referencia) VALUES ('$rfid','$referencia');
	";
	if (!$query=mysql_query($sql)) die("Erro SQL INSERT: ".mysql_error());
} else if ($operacao==2) {
	$sql="
		UPDATE cartoes SET rfid='$rfid',referencia='$referencia' WHERE codigo=$codigo
	";
	if (!$query=mysql_query($sql)) die("Erro SQL UPDATE: ".mysql_error());
} else {
	echo "Erro de parametros!";
	exit;
}

header("Location:"."cartoes.php");
die();


include("html_rodape.html");

?>