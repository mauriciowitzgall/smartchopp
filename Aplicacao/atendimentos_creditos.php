<?php

include "global.php";
$menuselecionado="atendimentos";
include "menu.php";

$atendimento=$_GET["codigo"];

//print_r($_REQUEST);

$tpl = new Template("atendimentos_creditos.html");
$tpl->ATENDIMENTO="$atendimento";
$sql="
	SELECT csm.nome as consumidor, a.modalidade as modalidade, ac.datahora as datahora, ac.valor as valor, ac.item as item, a.situacao as situacao
	FROM atendimentos a
	LEFT JOIN atendimentos_creditos ac on (a.codigo=ac.atendimento)	
	LEFT JOIN consumidores csm ON (a.consumidor=csm.codigo)	
	WHERE a.codigo=$atendimento
	$filtro_paginacao	
	ORDER BY ac.item desc
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
	$tpl->PAGINACAO_ANTERIOR_LINK="atendimentos_creditos.php?codigo=$atendimento&paginacao_inicio=$paginacao_anterior_inicio";
}
if ($paginacao_proxima_inicio>=$paginacao_qtditens) {
	$tpl->PAGINACAO_PROXIMA_LINK="#";
	$tpl->PAGINACAO_PROXIMA_CLASSE="disabled";
} else {
	$tpl->PAGINACAO_PROXIMA_LINK="atendimentos_creditos.php?codigo=$atendimento&paginacao_inicio=$paginacao_proxima_inicio";
}
$filtro_paginacao="LIMIT $paginacao_qtdporpagina OFFSET $paginacao_inicio";
$sql=$sql.$filtro_paginacao;


if (!$query0=mysql_query($sql)) die("Erro SQL 0: ".mysql_error());

//DADOS DE CABEÇALHO
$dados0=mysql_fetch_assoc($query0);

//Consumidor
$tpl->CONSUMIDOR=$dados0["consumidor"];


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
$tpl->SALDO="R$ ".number_format($saldo,2,",","");

//Situação
$situacao=$dados0["situacao"];
if ($situacao==0) $tpl->SITUACAO="Encerrado";
else  $tpl->SITUACAO="Em andamento";

//Botão Incluir Crédito
if ($situacao==0) {
	$tpl->BOTAO_INCLUIR_DESCRICAO="Não é possível incluir créditos em atendimentos encerrados!";
	$tpl->block("BLOCK_BOTAO_INCLUIR_DESABILITADO");
} else if ($situacao==1) {
	$tpl->block("BLOCK_BOTAO_INCLUIR");
}



//Lista de itens
while ($dados=mysql_fetch_assoc($query)) {

	$tpl->ITEM=$dados["item"];
	$situacao=$dados["situacao"];
	$datahora=$dados["datahora"];
	$tpl->DATA=converte_datahora2($datahora);
	$tpl->HORA=converte_datahora3($datahora);
	$valor=$dados["valor"];
	$tpl->VALOR="R$ ". number_format($dados["valor"],2,",","");

	//Verifica se ao remover o saldo ficará negativo, se sim não permite remover
	$saldo_novo=$saldo-$valor;
	if ($saldo_novo<0) {
		$tpl->DELETAR_DESCRICAO="Não é possível excluir este crédito porque o saldo ficaria NEGATIVO!";
		$tpl->block("BLOCK_DELETAR_DESABILITADO");
	} else if ($situacao==0) {
		$tpl->DELETAR_DESCRICAO="Não é possível excluir este crédito porque o atendimento está encerrado";
		$tpl->block("BLOCK_DELETAR_DESABILITADO");
	} else {
		$tpl->block("BLOCK_DELETAR");
	}


	$tpl->block("BLOCK_LINHA");
}

$tpl->show();

include("html_rodape.html");

?>