<?php

include "global.php";
$menuselecionado="atendimentos";
include "menu.php";

$atendimento=$_GET["codigo"];

//print_r($_REQUEST);

$tpl = new Template("atendimentos_consumo.html");
$tpl->ATENDIMENTO="$atendimento";
$sql="
	SELECT at.item as item, at.valor_unitario as valuni, at.valor_total as valtot, csm.nome as consumidor, chope, chopeira, quantidade, a.modalidade as modalidade
	FROM atendimentos a
	LEFT JOIN atendimentos_itens at on (a.codigo=at.atendimento)	
	LEFT JOIN consumidores csm ON (a.consumidor=csm.codigo)	
	WHERE a.codigo=$atendimento
	$filtro_paginacao	
	ORDER BY at.item desc
";

//Paginação
$paginacao_inicio=$_GET["paginacao_inicio"];
if ($paginacao_inicio=="") $paginacao_inicio="0";
if ($novabusca==1) $paginacao_inicio=0;
$paginacao_anterior_inicio=$paginacao_inicio-$paginacao_qtdporpagina;
$paginacao_proxima_inicio=$paginacao_inicio+$paginacao_qtdporpagina;
if (!$query=mysql_query($sql)) die("Erro SQL PAGINACAO: ".mysql_error());
$paginacao_qtditens=mysql_num_rows($query);
if ($paginacao_inicio==0) {
	$tpl->PAGINACAO_ANTERIOR_CLASSE="disabled";
	$tpl->PAGINACAO_ANTERIOR_LINK="#";
} else {
	$tpl->PAGINACAO_ANTERIOR_LINK="atendimentos_consumo.php?codigo=$atendimento&paginacao_inicio=$paginacao_anterior_inicio";
}
if ($paginacao_proxima_inicio>=$paginacao_qtditens) {
	$tpl->PAGINACAO_PROXIMA_LINK="#";
	$tpl->PAGINACAO_PROXIMA_CLASSE="disabled";
} else {
	$tpl->PAGINACAO_PROXIMA_LINK="atendimentos_consumo.php?codigo=$atendimento&paginacao_inicio=$paginacao_proxima_inicio";
}
$filtro_paginacao="LIMIT $paginacao_qtdporpagina OFFSET $paginacao_inicio";
$sql=$sql.$filtro_paginacao;


if (!$query=mysql_query($sql)) die("Erro SQL 2: ".mysql_error());

//DADOS DE CABEÇALHO
$dados=mysql_fetch_assoc($query);

//Consumidor
$tpl->CONSUMIDOR=$dados["consumidor"];

//Modalidade
$modalidade=$dados["modalidade"];
if ($modalidade==1) {
	$tpl->MODALIDADE="Pré-pago";
} else if ($dados["modalidade"]==2) {
	$tpl->MODALIDADE="Pós-pago";
} 
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
$tpl->SALDO="R$ ".number_format($saldo,2);


//Lista de itens
while ($dados=mysql_fetch_assoc($query)) {
	$tpl->ITEM=$dados["item"];
	$tpl->CHOPE=$dados["chope"];
	$tpl->CHOPEIRA=$dados["chopeira"];
	$tpl->VALUNI="R$ ".number_format($dados["valuni"],2,",","");
	$tpl->QTD=number_format($dados["quantidade"],3,",","")."";
	$tpl->VALTOT="R$ ". number_format($dados["valtot"],2,",","");
	$tpl->block("BLOCK_LINHA");
}

$tpl->show();

include("html_rodape.html");

?>