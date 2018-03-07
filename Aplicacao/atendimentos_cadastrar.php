<?php

include "global.php";
$menuselecionado="atendimentos";
include "menu.php";

$operacao=$_GET["operacao"];
$codigo=$_GET["codigo"];

$tpl = new Template("atendimentos_cadastrar.html");
$tpl->CODIGO=$codigo;
$tpl->OPERACAO=$operacao;


if ($operacao==2) {
	$sql="
		SELECT *
		FROM atendimentos
		WHERE codigo=$codigo		
	";
	if (!$query=mysql_query($sql)) die("Erro SQL 1: ".mysql_error());
	$dados=mysql_fetch_assoc($query);	
	$modalidade=$dados["modalidade"];
	//$tpl->NOVOCREDITO="R$ " . number_format($dados["valor"],2, ',', '.');
}

//Modalidade
$tpl->OPTION_MODALIDADE_VALOR=1;
$tpl->OPTION_MODALIDADE_NOME="Pré-Pago";	
if ($operacao==1) {
	if ($modalidade_padrao==1) $tpl->OPTION_MODALIDADE_SELECIONADO="selected";
	else $tpl->OPTION_MODALIDADE_SELECIONADO="";
} else {
	if ($modalidade==1) $tpl->OPTION_MODALIDADE_SELECIONADO="selected";
	else $tpl->OPTION_MODALIDADE_SELECIONADO="";	
}
$tpl->block("BLOCK_OPTION_MODALIDADE");
$tpl->OPTION_MODALIDADE_VALOR=2;
$tpl->OPTION_MODALIDADE_NOME="Pós-Pago";	
if ($operacao==1) {
	if ($modalidade_padrao==2) $tpl->OPTION_MODALIDADE_SELECIONADO="selected";
	else $tpl->OPTION_MODALIDADE_SELECIONADO="";
} else {
	if ($modalidade==2) $tpl->OPTION_MODALIDADE_SELECIONADO="selected";
	else $tpl->OPTION_MODALIDADE_SELECIONADO="";	
}
$tpl->block("BLOCK_OPTION_MODALIDADE");

//else $tpl->OPTION_CHOPE_SELECIONADO="";



$tpl->show();

include("html_rodape.html");

?>