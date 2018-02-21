
<?php

include "global.php";
$menuselecionado="atendimentos";
include "menu.php";

print_r($_POST);

$codigo=$_GET["atendimento"];
$saldo_devolvido=str_replace(",", ".", str_replace(".", "", str_replace("R$ ", "", $_POST["saldodevolvido"])));
$operacao=$_GET["operacao"];
$datahora_fim=$dataatual = date("Y-m-d H:i:s");
$atendimento=$codigo;

//NÃO mostrar erros e warnings na tela
error_reporting(E_ERROR | E_PARSE);


//Saldo
//Verifica qual é o total de crédito efetuados
$sql2="
	SELECT sum(ac.valor) as totcreditos
	FROM atendimentos_creditos ac
	WHERE ac.atendimento=$atendimento
";
if (!$query2=mysql_query($sql2)) die("Erro SQL 0: ".mysql_error());
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
$saldo_diferenca=$saldo-$saldo_devolvido;

$sql="
	UPDATE atendimentos SET situacao=0,saldo_devolvido='$saldo_devolvido',datahora_finalizacao='$datahora_fim', totcreditos='$totcreditos',totconsumo='$totconsumido',saldo='$saldo',saldo_diferenca='$saldo_diferenca' WHERE codigo=$codigo
";
if (!$query=mysql_query($sql)) die("Erro SQL UPDATE: ".mysql_error());


header("Location:"."atendimentos.php");
die();


include("html_rodape.html");

?>