<?php

include("html_cabecalho.html");
require("templates/Template.class.php");
error_reporting(E_ERROR | E_PARSE);

include("conexao.php");
$sql="SELECT * from configuracoes WHERE codigo=1";
if (!$query=mysql_query($sql)) die("Erro SQL CONFIGURACOES: ".mysql_error());
$dados=mysql_fetch_assoc($query);
$paginacao_qtdporpagina=$dados["paginacao"];

?>