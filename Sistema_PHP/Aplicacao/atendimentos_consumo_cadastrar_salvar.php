
<?php

include "global.php";
$menuselecionado="atendimentos";
include "menu.php";

print_r($_POST);

$operacao=$_GET["operacao"];
$atendimento=$_GET["atendimento"];
$item=$_GET["item"];
$data=$_POST["data"];
$hora=$_POST["hora"];
$datahora = $data." ".$hora;
$chopeira=$_POST["chopeira"];
$chope=$_POST["chope_codigo"];
$qtd=str_replace(",", ".", str_replace(".", "", str_replace("R$ ", "", $_POST["qtd"])));

echo $sql="SELECT * FROM chopes WHERE codigo=$chope";
if (!$query=mysql_query($sql)) die("Erro SQL UPDATE: ".mysql_error());
$dados=mysql_fetch_assoc($query);
$chope_nome=$dados["nome"];
$valuni=$dados["valunivenda"];
$valtot= $valuni*$qtd;

echo $sql="SELECT * FROM chopeiras WHERE codigo=$chopeira";
if (!$query=mysql_query($sql)) die("Erro SQL UPDATE: ".mysql_error());
$dados=mysql_fetch_assoc($query);
$chopeira_nome=$dados["nome"];

//NÃO mostrar erros e warnings na tela
error_reporting(E_ERROR | E_PARSE);

//Se for CADASTRO novo
if ($operacao==1) {
	echo $sql="
		INSERT INTO atendimentos_itens (atendimento, datahora, quantidade, valor_unitario, chopeira, chope, valor_total, chope_codigo,chopeira_codigo) VALUES ('$atendimento','$datahora', '$qtd', '$valuni', '$chopeira_nome', '$chope_nome', '$valtot', '$chope', '$chopeira');
	";
	if (!$query=mysql_query($sql)) die("Erro SQL INSERT: ".mysql_error());
} else if ($operacao==2) {
	
} else {
	echo "Erro de parametros!";
	exit;
}

header("Location:"."atendimentos_consumo.php?codigo=$atendimento");
die();


include("html_rodape.html");

?>