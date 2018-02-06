<?php

include "global.php";
$menuselecionado="consumidores";
include "menu.php";

$tpl = new Template("consumidores.html");
$tpl->show();



include("html_rodape.html");

?>