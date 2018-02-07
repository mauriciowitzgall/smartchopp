
<?php

include "global.php";
$menuselecionado="consumidores";
include "menu.php";

//print_r($_POST);

$codigo=$_GET["codigo"];
$nome=$_POST["nome"];
$telefone=$_POST["telefone"];
$cpf=$_POST["cpf"];
$email=$_POST["email"];
$operacao=$_GET["operacao"];

//NÃO mostrar erros e warnings na tela
error_reporting(E_ERROR | E_PARSE);

//Se for CADASTRO novo
if ($operacao==1) {
	$sql="
		INSERT INTO consumidores (nome,telefone,cpf,email) VALUES ('$nome','$telefone','$cpf','$email');
	";
	if (!$query=mysql_query($sql)) die("Erro SQL INSERT: ".mysql_error());
} else if ($operacao==2) {
	echo $sql="
		UPDATE consumidores SET nome='$nome',telefone='$telefone',cpf='$cpf',email='$email' WHERE codigo=$codigo
	";
	if (!$query=mysql_query($sql)) die("Erro SQL UPDATE: ".mysql_error());
} else {
	echo "Erro de parametros!";
	exit;
}

header("Location:"."consumidores.php");
die();


include("html_rodape.html");

?>