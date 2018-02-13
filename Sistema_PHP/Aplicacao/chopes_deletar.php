
<?php

include "global.php";
$menuselecionado="chopes";
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
	DELETE FROM chopes WHERE codigo=$codigo;
";
if (!$query=mysql_query($sql)) die("Erro SQL DELETE: ".mysql_error());

header("Location:"."chopes.php");
die();


include("html_rodape.html");

?>