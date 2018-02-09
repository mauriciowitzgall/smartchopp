<?php

include "global.php";
$menuselecionado="consumidores";
include "menu.php";

$operacao=$_GET["operacao"];
$codigo=$_GET["codigo"];

$tpl = new Template("consumidores_cadastrar.html");
$tpl->CODIGO=$codigo;
$tpl->OPERACAO=$operacao;

if ($operacao==2) {

	$sql="
		SELECT *
		FROM consumidores		
		WHERE codigo=$codigo		
	";
	if (!$query=mysql_query($sql)) die("Erro SQL 1: ".mysql_error());
	while ($dados=mysql_fetch_assoc($query)) {
		$tpl->NOME=$dados["nome"];
		$tpl->TELEFONE=$dados["telefone"];
		$tpl->CPF=$dados["cpf"];
		$tpl->EMAIL=$dados["email"];

	}
	




}




$tpl->show();

include("html_rodape.html");

?>