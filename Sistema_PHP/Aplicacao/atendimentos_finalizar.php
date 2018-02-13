<?php

include "global.php";
$menuselecionado="atendimentos";
include "menu.php";

$operacao=$_GET["operacao"];
$atendimento=$_GET["codigo"];

$tpl = new Template("atendimentos_finalizar.html");
$tpl->ATENDIMENTO=$atendimento;
$tpl->OPERACAO=$operacao;

$datahora_fim=$dataatual = date("Y-m-d H:i:s");


//Pega nome do consumidor
$sql="
	SELECT csm.nome as consumidor,a.datahora as datahora_inicio
	FROM atendimentos a 
	LEFT JOIN consumidores csm on (a.consumidor=csm.codigo)	
	WHERE a.codigo=$atendimento
";
if (!$query=mysql_query($sql)) die("Erro SQL 1: ".mysql_error());
$dados=mysql_fetch_assoc($query);
$tpl->CONSUMIDOR=$dados["consumidor"];	
$tpl->DATAHORA_INI=converte_datahora4($dados["datahora_inicio"]);	
$tpl->DATAHORA_FIM=converte_datahora4($datahora_fim);	

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


$tpl->show();

include("html_rodape.html");

?>