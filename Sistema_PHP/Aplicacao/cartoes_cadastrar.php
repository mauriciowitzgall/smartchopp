<?php

include "global.php";
$menuselecionado="cartoes";
include "menu.php";

$operacao=$_GET["operacao"];
$codigo=$_GET["codigo"];

$tpl = new Template("cartoes_cadastrar.html");
$tpl->CODIGO=$codigo;
$tpl->OPERACAO=$operacao;

if ($operacao==2) {

	$sql="
		SELECT *
		FROM cartoes		
		WHERE codigo=$codigo		
	";
	if (!$query=mysql_query($sql)) die("Erro SQL 1: ".mysql_error());
	while ($dados=mysql_fetch_assoc($query)) {
		$tpl->RFID=$dados["rfid"];
		$tpl->REFERENCIA=$dados["referencia"];		
	}
}

$tpl->show();

include("html_rodape.html");

?>