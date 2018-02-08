<?php

include "global.php";
$menuselecionado="chopeiras";
include "menu.php";

//print_r($_REQUEST);

$tpl = new Template("chopeiras.html");

$busca=$_REQUEST["busca"];
$novabusca=$_POST["novabusca"];
if ($busca!="") {
	$sql_filtro="
		AND (
			(cpr.codigo like '%$busca%')||
			(cpr.nome like '%$busca%')||
			(cho.nome like '%$busca%')||
			(eqp.nome like '%$busca%')||
			(cpr.quantidade like '%$busca%')
		) 
	";
}
$tpl->BUSCA=$busca;

$sql="
	SELECT DISTINCT cpr.nome as chopeira_nome, cho.nome as chope_nome, eqp.nome as equipamento_nome, cpr.quantidade as quantidade, cpr.codigo as chopeira_codigo, cpr.capacidade as capacidade
	FROM chopeiras cpr
	LEFT JOIN equipamentos eqp on (cpr.equipamento=eqp.codigo)	
	LEFT JOIN chopes cho on (cpr.chope=cho.codigo)
	WHERE 1 
	$sql_filtro
	$filtro_paginacao
	ORDER BY cpr.quantidade/cpr.capacidade*100 
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
	$tpl->PAGINACAO_ANTERIOR_LINK="chopeiras.php?paginacao_inicio=$paginacao_anterior_inicio&busca=$busca";
}
if ($paginacao_proxima_inicio>=$paginacao_qtditens) {
	$tpl->PAGINACAO_PROXIMA_LINK="#";
	$tpl->PAGINACAO_PROXIMA_CLASSE="disabled";
} else {
	$tpl->PAGINACAO_PROXIMA_LINK="chopeiras.php?paginacao_inicio=$paginacao_proxima_inicio&busca=$busca";
}
$filtro_paginacao="LIMIT $paginacao_qtdporpagina OFFSET $paginacao_inicio";
$sql=$sql.$filtro_paginacao;



if (!$query=mysql_query($sql)) die("Erro SQL 2: ".mysql_error());
while ($dados=mysql_fetch_assoc($query)) {
	$codigo=$dados["chopeira_codigo"];
	$tpl->CODIGO=$dados["chopeira_codigo"];
	$tpl->NOME=$dados["chopeira_nome"];
	$tpl->CHOPE=$dados["chope_nome"];
	$tpl->EQUIPAMENTO=$dados["equipamento_nome"];		
	$percentual=number_format($dados["quantidade"]/$dados["capacidade"]*100,0);			
	$tpl->PERCENTUAL="$percentual";			
	if ($percentual<=10) $tpl->BARRINHA_COR="bar-danger";
	else if ($percentual<=35) $tpl->BARRINHA_COR="bar-warning";
	else $tpl->BARRINHA_COR="bar-success";			
	
	$tpl->block("BLOCK_EDITAR");
	//$tpl->block("BLOCK_EDITAR_DESABILITADO");


	$tpl->block("BLOCK_DELETAR");
	
	

	$tpl->block("BLOCK_LINHA");
}

$tpl->show();

include("html_rodape.html");

?>