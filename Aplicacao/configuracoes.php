<?php

include "global.php";
$menuselecionado="configuracoes";
include "menu.php";

$tpl = new Template("configuracoes.html");

$tpl->show();



include("html_rodape.html");

?>