
<?php

include "global.php";
$menuselecionado="atendimentos";
include "menu.php";

print_r($_POST);

$codigo=$_GET["codigo"];
$rfid=$_POST["rfid"];
$telefone=$_POST["telefone"];
$consumidor=$_POST["consumidor"];
$consumidor_id=$_POST["consumidor_id"];
$modalidade=$_POST["modalidade"];
$creditoinicial=str_replace(",", ".", str_replace(".", "", str_replace("R$ ", "", $_POST["creditoinicial"])));
$operacao=$_GET["operacao"];

//NÃO mostrar erros e warnings na tela
error_reporting(E_ERROR | E_PARSE);

//Se já estiver cadastrado o cartão, apenas seleciona, senão, cadastra o cartão
$sql="SELECT codigo FROM cartoes WHERE rfid like '$rfid'";
if (!$query=mysql_query($sql)) die("Erro SQL: ".mysql_error());
$dados=mysql_fetch_assoc($query);
$linhas=mysql_num_rows($query);
if ($linhas==1) {
	$cartao_codigo=$dados["codigo"];
} else if ($linhas > 1 ) {
	echo "Existe mais de um cartão com este RFID!";
	exit;
} else {
	$sql1="INSERT INTO cartoes (rfid) VALUES ('$rfid')";
	if (!$query1=mysql_query($sql1)) die("Erro SQL INSERT Cartão: ".mysql_error());
	$cartao_codigo=mysql_insert_id();
}

//Se não foi selecionado um consumidor, cadastrar um novo consumidor.
if ($consumidor_id > 0) {
	$consumidor_codigo=$consumidor_id;
} else {
	$sql1="INSERT INTO consumidores (nome,telefone) VALUES ('$consumidor','$telefone')";
	if (!$query1=mysql_query($sql1)) die("Erro SQL INSERT Cartão: ".mysql_error());
	$consumidor_codigo=mysql_insert_id();	
}





//Se for CADASTRO novo
if ($operacao==1) {

	//Inserir atendimento
	$sql="
		INSERT INTO atendimentos (cartao,consumidor,modalidade,situacao) VALUES ('$cartao_codigo','$consumidor_codigo','$modalidade',1);
	";
	if (!$query=mysql_query($sql)) die("Erro SQL INSERT: ".mysql_error());
	$atendimento_ultimo=mysql_insert_id();	
	
	//Verifica se tem credito de antendimentos anteriores e insere como credito inicial
	$sql="SELECT * FROM atendimentos where consumidor=$consumidor_codigo and situacao=0 ORDER BY codigo DESC LIMIT 1";
	if (!$query=mysql_query($sql)) die("Erro SQL: ".mysql_error());
	$dados=mysql_fetch_assoc($query);
	$creditoanterior=$dados["saldo_diferenca"];
	if ($creditoanterior>0) {
		$sql1="INSERT INTO atendimentos_creditos (atendimento,valor) VALUES ('$atendimento_ultimo','$creditoanterior')";
		if (!$query1=mysql_query($sql1)) die("Erro SQL INSERT Crédito: ".mysql_error());
	}

	//Inserir crédito inicial
	$sql1="INSERT INTO atendimentos_creditos (atendimento,valor) VALUES ('$atendimento_ultimo','$creditoinicial')";
	if (!$query1=mysql_query($sql1)) die("Erro SQL INSERT Crédito: ".mysql_error());


} else if ($operacao==2) {
	
} else {
	echo "Erro de parametros!";
	exit;
}

header("Location:"."atendimentos.php");
die();


include("html_rodape.html");

?>