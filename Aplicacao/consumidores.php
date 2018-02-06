<?php

include "global.php";
$menuselecionado="consumidores";
include "menu.php";


$tpl = new Template("consumidores.html");

$sql="
	SELECT *
	FROM consumidores
	ORDER BY nome
";
if (!$query=mysql_query($sql)) die("Erro SQL 2: ".mysql_error());
while ($dados=mysql_fetch_assoc($query)) {
	$tpl->CODIGO=$dados["codigo"];
	$tpl->NOME=$dados["nome"];
	$tpl->FONE=$dados["telefone"];
	$tpl->CPF=$dados["cpf"];
	$tpl->EMAIL=$dados["email"];
	$valuni=$dados["valuni"];
	$chopeira_nome=$dados["chopeira"];
	$chope_nome=$dados["chope"];
	$tpl->block("BLOCK_LINHA");
}

$tpl->show();



include("html_rodape.html");

?>