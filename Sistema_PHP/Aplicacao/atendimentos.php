<?php

include "global.php";
$menuselecionado="atendimentos";
include "menu.php";

//print_r($_REQUEST);

$tpl = new Template("atendimentos.html");

$busca=$_REQUEST["busca"];
$novabusca=$_POST["novabusca"];
if ($busca!="") {
	$sql_filtro="
		AND (
			(a.codigo like '%$busca%')||
			(csm.nome like '%$busca%')||
			(car.rfid like '%$busca%')||
			(car.referencia like '%$busca%')||
			(cpr.nome like '%$busca%')||
			(cpr.nome like '%$busca%')||
			(cho.nome like '%$busca%')||
			(eqp.nome like '%$busca%')||
			(a.valtot like '%$busca%')
		) 
	";
}
$tpl->BUSCA=$busca;

$sql="
	SELECT a.codigo as codigo, csm.nome as consumidor, a.modalidade as modalidade, a.situacao as situacao, a.datahora as data_inicio, a.datahora_finalizacao as data_saida
	FROM atendimentos a 
	LEFT JOIN atendimentos_itens at on (a.codigo=at.atendimento)
	LEFT JOIN chopeiras cpr ON (at.chopeira_codigo=cpr.codigo)	
	LEFT JOIN equipamentos eqp ON (cpr.equipamento=eqp.codigo)	
	LEFT JOIN chopes cho ON (at.chope_codigo=cho.codigo)	
	LEFT JOIN cartoes car ON (a.cartao=car.codigo)	
	LEFT JOIN consumidores csm ON (a.consumidor=csm.codigo)	
	WHERE 1 
	$sql_filtro
	$filtro_paginacao
	GROUP BY a.codigo
	ORDER BY a.situacao desc,a.codigo desc
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
	$tpl->PAGINACAO_ANTERIOR_LINK="atendimentos.php?paginacao_inicio=$paginacao_anterior_inicio&busca=$busca";
}
if ($paginacao_proxima_inicio>=$paginacao_qtditens) {
	$tpl->PAGINACAO_PROXIMA_LINK="#";
	$tpl->PAGINACAO_PROXIMA_CLASSE="disabled";
} else {
	$tpl->PAGINACAO_PROXIMA_LINK="atendimentos.php?paginacao_inicio=$paginacao_proxima_inicio&busca=$busca";
}
$filtro_paginacao="LIMIT $paginacao_qtdporpagina OFFSET $paginacao_inicio";
$sql=$sql.$filtro_paginacao;

if (!$query=mysql_query($sql)) die("Erro SQL 2: ".mysql_error());
while ($dados=mysql_fetch_assoc($query)) {
	$codigo=$dados["codigo"];
	$situacao=$dados["situacao"];
	$tpl->CODIGO=$dados["codigo"];
	$tpl->DATA_INICIO=converte_datahorabanco_para_datahoratela3($dados["data_inicio"]);

	//Cor da linha
	if ($situacao==0) {
		//$tpl->LINHA_CLASSE="error";
	} else if ($situacao==1) {
		//$tpl->LINHA_CLASSE="";
	} 

	//Consumidor
	$tpl->CONSUMIDOR=$dados["consumidor"];
	
	//Modalidade
	$modalidade=$dados["modalidade"];
	if ($modalidade==1) {
		$tpl->MODALIDADE="Pré-pago";
		$tpl->MODALIDADE_CLASSE="text-success";
	} else if ($dados["modalidade"]==2) {
		$tpl->MODALIDADE="Pós-pago";
		$tpl->MODALIDADE_CLASSE="text-error";
	} else {
		$tpl->MODALIDADE_CLASSE="";
	}

	//Saldo
	//Verifica qual é o total de crédito efetuados
	$sql2="
		SELECT sum(ac.valor) as totcreditos
		FROM atendimentos_creditos ac
		WHERE ac.atendimento=$codigo
	";
	if (!$query2=mysql_query($sql2)) die("Erro SQL 2: ".mysql_error());
	$dados2=mysql_fetch_assoc($query2);
	$totcreditos=$dados2["totcreditos"];
	//print_r("<br> Total Créditos: $totcreditos ");

	//Verifica qual é o total consumido
	$sql3="
		SELECT sum(ai.valor_total) as valtot
		FROM atendimentos_itens ai
		WHERE ai.atendimento=$codigo
	";
	$totconsumido=0;
	if (!$query3=mysql_query($sql3)) die("Erro SQL 3: ".mysql_error());
	$dados3=mysql_fetch_assoc($query3);
	$totconsumido=$dados3["valtot"];

	$saldo=$totcreditos-$totconsumido;
	$tpl->SALDO="R$ ".number_format($saldo,2,",","");

	//Itens
	$sql4="SELECT count(item) as itens FROM atendimentos_itens WHERE atendimento=$codigo";
	if (!$query4=mysql_query($sql4)) die("Erro SQL 4: ".mysql_error());
	$dados4=mysql_fetch_assoc($query4);
	$itens=$dados4["itens"];
	$tpl->ITENS="$itens";

	//Situção
	if ($situacao==0) {
		$tpl->SITUACAO="Encerrado";
		$tpl->SITUACAO_CLASSE="text-error";
	} else if ($situacao==1) {
		$tpl->SITUACAO="Em andamento";
		$tpl->SITUACAO_CLASSE="text-success";
	} else {
		$tpl->SITUACAO_CLASSE="";
	}	

	//Data Saida
	$data_saida=$dados["data_saida"];		
	if ($data_saida=="") $data_saida="---";
	else $data_saida=converte_datahorabanco_para_datahoratela3($data_saida);
	$tpl->DATA_SAIDA="$data_saida";

	//Icone créditos
	if ($modalidade==1) $tpl->block("BLOCK_CREDITOS");
	else if ($modalidade==2) {
		$tpl->CREDITO_DESCRICAO="Somente atendimentos PRÉ-PAGO podem incluir créditos!";
		$tpl->block("BLOCK_CREDITOS_DESABILITADO");
	}
	
	//Icone consumo
	$tpl->block("BLOCK_CONSUMO");
	
	//Icone Finalizar
	if ($situacao==0) $tpl->block("BLOCK_FINALIZAR_DESABILITADO");
	else $tpl->block("BLOCK_FINALIZAR");

	$tpl->block("BLOCK_LINHA");
}

$tpl->show();

include("html_rodape.html");

?>