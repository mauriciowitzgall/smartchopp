<?php

include "global.php";
$menuselecionado="chopeiras";
include "menu.php";

$operacao=$_GET["operacao"];
$codigo=$_GET["codigo"];

$tpl = new Template("chopeiras_cadastrar.html");
$tpl->CODIGO=$codigo;
$tpl->OPERACAO=$operacao;

if ($operacao==2) {
	$sql="
		SELECT *
		FROM chopeiras		
		WHERE codigo=$codigo		
	";
	if (!$query=mysql_query($sql)) die("Erro SQL 1: ".mysql_error());
	while ($dados=mysql_fetch_assoc($query)) {
		//$tpl->CODIGO=$dados["codigo"];
		$tpl->NOME=$dados["nome"];
		$tpl->CAPACIDADE=number_format($dados["capacidade"],3,",","");
		$tpl->QUANTIDADE=number_format($dados["quantidade"],3,",","");
		$chope=$dados["chope"];
		$equipamento=$dados["equipamento"];
	
	}
}

//Chopes
$sql="SELECT * FROM chopes WHERE ativo=1";
if (!$query=mysql_query($sql)) die("Erro SQL 2: ".mysql_error());
while ($dados=mysql_fetch_assoc($query)) {
	$tpl->OPTION_CHOPE_VALOR=$dados["codigo"];
	$tpl->OPTION_CHOPE_NOME=$dados["nome"];	
	if ($chope==$dados["codigo"]) $tpl->OPTION_CHOPE_SELECIONADO="selected";
	else $tpl->OPTION_CHOPE_SELECIONADO="";
	$tpl->block("BLOCK_OPTION_CHOPE");
}

//Equipamentos
$sql="SELECT codigo, nome FROM equipamentos WHERE codigo not in (SELECT DISTINCT equipamento FROM chopeiras WHERE ativo=1)";
if (!$query=mysql_query($sql)) die("Erro SQL 2: ".mysql_error());
while ($dados=mysql_fetch_assoc($query)) {
	$tpl->OPTION_EQUIPAMENTO_VALOR=$dados["codigo"];
	$tpl->OPTION_EQUIPAMENTO_NOME=$dados["nome"];	
	if ($equipamento==$dados["codigo"]) $tpl->OPTION_EQUIPAMENTO_SELECIONADO="selected";
	else $tpl->OPTION_EQUIPAMENTO_SELECIONADO="";
	$tpl->block("BLOCK_OPTION_EQUIPAMENTO");
}


$tpl->show();

include("html_rodape.html");

?>