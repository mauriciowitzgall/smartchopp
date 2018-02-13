
<?php

include "global.php";
$menuselecionado="chopeiras";
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
	DELETE FROM chopeiras WHERE codigo=$codigo;
";
if (!$query=mysql_query($sql)) die("Erro SQL DELETE: ".mysql_error());

header("Location:"."chopeiras.php");
die();


include("html_rodape.html");

?>