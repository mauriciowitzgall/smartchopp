<?php

include "global.php";
$menuselecionado="atendimentos";
include "menu.php";

$operacao=$_GET["operacao"];
$atendimento=$_GET["atendimento"];
$item=$_GET["item"];

$tpl = new Template("atendimentos_creditos_cadastrar.html");
$tpl->ATENDIMENTO=$atendimento;
$tpl->ITEM="aa".$item;
$tpl->OPERACAO=$operacao;

$sql="
	SELECT csm.nome as consumidor
	FROM atendimentos_creditos as ac
	LEFT JOIN atendimentos a on (ac.atendimento=a.codigo)	
	LEFT JOIN consumidores csm on (a.consumidor=csm.codigo)	
	WHERE ac.atendimento=$atendimento
";
if (!$query=mysql_query($sql)) die("Erro SQL 1: ".mysql_error());
$dados=mysql_fetch_assoc($query);
$tpl->CONSUMIDOR=$dados["consumidor"];	

//Saldo
//Verifica qual é o total de crédito efetuados
$sql2="
	SELECT sum(ac.valor) as totcreditos
	FROM atendimentos_creditos ac
	WHERE ac.atendimento=$atendimento
";
if (!$query2=mysql_query($sql2)) die("Erro SQL 2: ".mysql_error());
$dados2=mysql_fetch_assoc($query2);
$totcreditos=$dados2["totcreditos"];
//Verifica qual é o total consumido
$sql3="
	SELECT sum(ai.valor_total) as valtot
	FROM atendimentos_itens ai
	WHERE ai.atendimento=$atendimento
";
$totconsumido=0;
if (!$query3=mysql_query($sql3)) die("Erro SQL 3: ".mysql_error());
$dados3=mysql_fetch_assoc($query3);
$totconsumido=$dados3["valtot"];
$saldo=$totcreditos-$totconsumido;
$tpl->TOTCREDITOS="R$ ".number_format($totcreditos,2,",","");
$tpl->TOTCONSUMIDO="R$ ".number_format($totconsumido,2,",","");
$tpl->SALDO="R$ ".number_format($saldo,2,",","");

if ($operacao==2) {
	$sql="
		SELECT ac.valor as valor
		FROM atendimentos_creditos as ac		
		WHERE ac.atendimento=$atendimento
		AND ac.item=$item
	";
	if (!$query=mysql_query($sql)) die("Erro SQL 1: ".mysql_error());
	$dados=mysql_fetch_assoc($query);	
	$tpl->NOVOCREDITO="R$ " . number_format($dados["valor"],2, ',', '.');
}

$tpl->show();

include("html_rodape.html");

?>