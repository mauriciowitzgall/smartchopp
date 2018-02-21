<?php

echo "INICIADO!";

include("conexao.php");

//NÃO mostrar erros e warnings na tela
error_reporting(E_ERROR | E_PARSE);

$rfid=$_GET["rfid"];
$equipamento=$_GET["equip"];
$quantidade=$_GET["qtd"];
$quantidade=$quantidade/1000;

//Verifica se foi recebido todos os campos do get
if (($rfid=="")||($equipamento=="")||($quantidade=="")) {
	echo "ERRO: Você esqueceu de enviar algum parametro por GET!";
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
	echo "ERRO: Há mais de um atendimento ativo com este mesmo cartão!";
	exit;
}
$dados=mysql_fetch_assoc($query);
$atendimento=$dados["atendimento_codigo"];

//Verifica qual é o valor unitário do chope
$sql="
	SELECT cho.valunivenda as valuni,cho.nome as chope, cpr.nome as chopeira,cpr.codigo as chopeira_codigo
	FROM chopeiras cpr 
	JOIN chopes cho on (cpr.chope=cho.codigo) 
	JOIN equipamentos eqp on (cpr.equipamento=eqp.codigo) 
	WHERE eqp.referencia like '$equipamento'
	and cpr.ativo=1
";
if (!$query=mysql_query($sql)) die("Erro SQL 2: ".mysql_error());
$dados=mysql_fetch_assoc($query);
$valuni=$dados["valuni"];
$chopeira_nome=$dados["chopeira"];
$chopeira_codigo=$dados["chopeira_codigo"];
$chope_nome=$dados["chope"];

//Verifica qual é o total de crédito efetuados
$sql="
	SELECT sum(ac.valor) as totcreditos
	FROM atendimentos_creditos ac
	WHERE ac.atendimento=$atendimento
";
if (!$query=mysql_query($sql)) die("Erro SQL 2: ".mysql_error());
$dados=mysql_fetch_assoc($query);
$totcreditos=$dados["totcreditos"];

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

//Saldo disponível
$saldo=$totcreditos-$totconsumido;

//Verifica qual é o ultimo item do atendimento
$sql="
	SELECT max(ai.item) as item_ultimo
	FROM atendimentos_itens ai
	WHERE ai.atendimento=$atendimento
";
$totconsumido=0;
if (!$query=mysql_query($sql)) die("Erro SQL: ".mysql_error());
$dados=mysql_fetch_assoc($query);
$item_ultimo=$dados["item_ultimo"];
$item_proximo=$item_ultimo+1;
//asdf
$qtdmaxima=$saldo/$valuni;

//Valor total 
$valtot=$valuni*$quantidade;

//print_r("<br> Atendimento: $atendimento");
//print_r("<br> Chopeira: $chopeira");
//print_r("<br> Chope: $chope");
//print_r("<br> Total Créditos: $totcreditos ");
//print_r("<br> Total Consumido: ".number_format($totconsumido,2));
print_r("<br> Saldo: ".number_format($saldo,2));
//print_r("<br> Quantidade máxima: ".number_format($qtdmaxima,3));
//print_r("<br> Quantidade/Porção: ".number_format($quantidade,3));
//print_r("<br> Valor Unitário: $valuni ");
print_r("<br> Valor total deste lançamento: ".number_format($valtot,2));


//Verifica se valor a ser inserido é maiorque o maximo permitido, com uma pequena tolerancia
//if (($valtot-) > $saldo) {
	//echo "<br><br>ERRO: O valor total deste lançamento é maior que o saldo disponível <br>";
	//exit;
//}

print_r("<br> Saldo novo: ".number_format($saldo-$valtot,2));

$sql="
	INSERT INTO atendimentos_itens
	(
		atendimento,
		item,
		quantidade,
		valor_unitario,
		chopeira,
		chope,
		valor_total
	)
	VALUES
	(
		$atendimento,
		$item_proximo,
		$quantidade,
		$valuni,
		'$chopeira_nome',
		'$chope_nome',
		$valtot
	);
";
if (!$query=mysql_query($sql)) die("Erro de SQL ao inserir o consumo no atendimento! ".mysql_error());

$sql="UPDATE chopeiras SET quantidade=quantidade-$quantidade WHERE codigo=$chopeira_codigo";
if (!$query=mysql_query($sql)) die("Erro de SQL ao atualizar quantidade da chopeira! ".mysql_error());

echo "<br>FINALIZADO";

?>
