<?php

include "global.php";
$menuselecionado="cartoes";
include "menu.php";


$tpl = new Template("chopes.html");
$tpl->show();



include("html_rodape.html");

?>