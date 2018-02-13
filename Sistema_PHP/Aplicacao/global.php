<?php

include("html_cabecalho.html");
require("templates/Template.class.php");
error_reporting(E_ERROR | E_PARSE);

//Define fuso horário atual para função DATE
date_default_timezone_set('America/Sao_Paulo');

include("conexao.php");
include("funcoes.php");

$sql="SELECT * from configuracoes WHERE codigo=1";
if (!$query=mysql_query($sql)) die("Erro SQL CONFIGURACOES: ".mysql_error());
$dados=mysql_fetch_assoc($query);
$paginacao_qtdporpagina=$dados["paginacao"];
$modalidade_padrao=$dados["modalidade"];

?>