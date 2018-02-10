<?php

include("conexao.php");

//NÃO mostrar erros e warnings na tela
error_reporting(E_ERROR | E_PARSE);

$rfid=$_GET["rfid"];
$equipamento=$_GET["equip"];




//Verifica se foi recebido todos os campos do get
if (($rfid=="")||($equipamento=="")) {
	echo "-1";
	//echo "ERRO: Você esqueceu de enviar algum parametro por GET!";
	exit;	
}


//Verifica se há um atentimento ativo para o RFID recebido
$sql="
	SELECT a.codigo as atendimento_codigo 
	FROM atendimentos a 
	JOIN cartoes car on (a.cartao=car.codigo)
	WHERE car.rfid='$rfid' 
	AND a.situacao=1
";
if (!$query=mysql_query($sql)) die("Erro SQL 1: ".mysql_error());
$linhas=mysql_num_rows($query);
if ($linhas>1) {
	//echo "ERRO: Há mais de um atendimento ativo com este cartão!";
	echo "-2";
	exit;
}
if ($linhas==0) {
	//echo "ERRO: Não há atendimentos ativo com este mesmo cartão!";
	echo "-3";
	exit;
}
$dados=mysql_fetch_assoc($query);
$atendimento=$dados["atendimento_codigo"];
//print_r("<br> Atendimento: $atendimento");

//Verifica qual é o valor unitário do chope
$sql="
	SELECT cho.valunivenda as valuni,cho.nome as chope
	FROM chopeiras cpr 
	JOIN chopes cho on (cpr.chope=cho.codigo) 
	JOIN equipamentos eqp on (cpr.equipamento=eqp.codigo) 
	WHERE eqp.referencia like '$equipamento'
	and cpr.ativo=1
";
if (!$query=mysql_query($sql)) die("Erro SQL 2: ".mysql_error());
$dados=mysql_fetch_assoc($query);
$valuni=$dados["valuni"];
$chope=$dados["chope"];
//print_r("<br> Chope: $chope");
//print_r("<br> Valor Unitário: $valuni ");

//Verifica qual é o total de crédito efetuados
$sql="
	SELECT sum(ac.valor) as totcreditos
	FROM atendimentos_creditos ac
	WHERE ac.atendimento=$atendimento
";
if (!$query=mysql_query($sql)) die("Erro SQL 2: ".mysql_error());
$dados=mysql_fetch_assoc($query);
$totcreditos=$dados["totcreditos"];
//print_r("<br> Total Créditos: $totcreditos ");

//Verifica qual é o total consumido
$sql="
	SELECT sum(ai.valor_total) as valtot
	FROM atendimentos_itens ai
	WHERE ai.atendimento=$atendimento
";
$totconsumido=0;
if (!$query=mysql_query($sql)) die("Erro SQL 2: ".mysql_error());
$dados=mysql_fetch_assoc($query);
$totconsumido=$dados["valtot"];

//print_r("<br> Total Consumido: ".number_format($totconsumido,2));

//Saldo disponível
$saldo=$totcreditos-$totconsumido;
//print_r("<br> Saldo: ".number_format($saldo,2));

if ($saldo<=0) {
	//echo "ERRO: Saldo insuficiente
	echo "-4";
	exit;		
}


$qtdmaxima=$saldo/$valuni;
//print_r("<br> Quantidade máxima: ".number_format($qtdmaxima,3));
$qtdmaxima=number_format($qtdmaxima,3);
$valuni=number_format($valuni,2);

echo "1|$valuni|$qtdmaxima";

?>