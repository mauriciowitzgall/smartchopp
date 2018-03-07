<?php 

include "conexao.php";

$rfid=$_POST["rfid"];

$sql="SELECT csm.nome as consumidor_nome FROM atendimentos a join cartoes car on (a.cartao=car.codigo) LEFT JOIN consumidores csm on (a.consumidor=csm.codigo) WHERE car.rfid like '$rfid' and situacao=1";
if (!$query=mysql_query($sql)) die("Erro SQL: ".mysql_error());
$linhas=mysql_num_rows($query);
$dados=mysql_fetch_assoc($query);
$consumidor_nome=$dados["consumidor_nome"];
if ($linhas >= 1) {
	//echo "Há mais de um atendimento com o mesmo rfid";
	echo "duplicado|$consumidor_nome";
} else {
	echo "permitido";
}
?>