<?php

include "global.php";
$menuselecionado="consumidores";
include "menu.php";

//print_r($_REQUEST);

$tpl = new Template("consumidores.html");

$busca=$_REQUEST["busca"];
$novabusca=$_POST["novabusca"];
if ($busca!="") {
	$sql_filtro="
		AND (
			(codigo like '%$busca%')||
			(nome like '%$busca%')||
			(telefone like '%$busca%')||
			(cpf like '%$busca%') ||
			(email like '%$busca%')
		) 
	";
}
$tpl->BUSCA=$busca;

$sql="
	SELECT *
	FROM consumidores
	WHERE 1 
	$sql_filtro
	$filtro_paginacao
	ORDER BY codigo
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
	$tpl->PAGINACAO_ANTERIOR_LINK="consumidores.php?paginacao_inicio=$paginacao_anterior_inicio&busca=$busca";
}
if ($paginacao_proxima_inicio>$paginacao_qtditens) {
	$tpl->PAGINACAO_PROXIMA_LINK="#";
	$tpl->PAGINACAO_PROXIMA_CLASSE="disabled";
} else {
	$tpl->PAGINACAO_PROXIMA_LINK="consumidores.php?paginacao_inicio=$paginacao_proxima_inicio&busca=$busca";
}
$filtro_paginacao="LIMIT $paginacao_qtdporpagina OFFSET $paginacao_inicio";
$sql=$sql.$filtro_paginacao;



if (!$query=mysql_query($sql)) die("Erro SQL 2: ".mysql_error());
while ($dados=mysql_fetch_assoc($query)) {
	$codigo=$dados["codigo"];
	$tpl->CODIGO=$dados["codigo"];
	$tpl->NOME=$dados["nome"];
	$tpl->FONE=$dados["telefone"];
	$tpl->CPF=$dados["cpf"];
	$tpl->EMAIL=$dados["email"];
	$valuni=$dados["valuni"];
	$chopeira_nome=$dados["chopeira"];
	$chope_nome=$dados["chope"];

	$tpl->block("BLOCK_EDITAR");
	//$tpl->block("BLOCK_EDITAR_DESABILITADO");

	//Verifica se o consumidor tem atendimentos vinculados
	$sql2="SELECT * FROM atendimentos WHERE consumidor=$codigo";
	if (!$query2=mysql_query($sql2)) die("Erro SQL 2: ".mysql_error());
	if (mysql_num_rows($query2)>0) {
		$tpl->DELETAR_DESCRICAO="Não é possível excluir este consumidor porque ele possui atendimentos vinculados!";
		$tpl->block("BLOCK_DELETAR_DESABILITADO");
	} else {
		$tpl->block("BLOCK_DELETAR");
	}
	

	$tpl->block("BLOCK_LINHA");
}

$tpl->show();

include("html_rodape.html");

?>