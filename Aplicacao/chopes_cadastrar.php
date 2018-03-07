<?php

include "global.php";
$menuselecionado="chopes";
include "menu.php";

$operacao=$_GET["operacao"];
$codigo=$_GET["codigo"];

$tpl = new Template("chopes_cadastrar.html");
$tpl->CODIGO=$codigo;
$tpl->OPERACAO=$operacao;

if ($operacao==2) {

	$sql="
		SELECT *
		FROM chopes		
		WHERE codigo=$codigo		
	";
	if (!$query=mysql_query($sql)) die("Erro SQL 1: ".mysql_error());
	while ($dados=mysql_fetch_assoc($query)) {
		$tpl->NOME=$dados["nome"];
		$tpl->VALUNI="R$ " . number_format($dados["valunivenda"],2, ',', '.');
		$tpl->DESCRICAO=$dados["descricao"];		
	}
}

$tpl->show();

include("html_rodape.html");

?>