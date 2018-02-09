
<?php

include "global.php";
$menuselecionado="cartoes";
include "menu.php";

print_r($_POST);

$codigo=$_GET["codigo"];

if ($codigo=="") {
	echo "Erro de parametros!";
	exit;
}	

//NÃO mostrar erros e warnings na tela
error_reporting(E_ERROR | E_PARSE);


$sql="
	DELETE FROM cartoes WHERE codigo=$codigo;
";
if (!$query=mysql_query($sql)) die("Erro SQL DELETE: ".mysql_error());

header("Location:"."cartoes.php");
die();


include("html_rodape.html");

?>