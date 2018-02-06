<?php


$tpl = new Template("menu.html");
if ($menuselecionado=="configuracoes") $tpl->block("BLOCK_MENU_SELECIONADO_CONFIGURACOES");
if ($menuselecionado=="consumidores") $tpl->block("BLOCK_MENU_SELECIONADO_CONSUMIDORES");
if ($menuselecionado=="chopes") $tpl->block("BLOCK_MENU_SELECIONADO_CHOPES");
if ($menuselecionado=="chopeiras") $tpl->block("BLOCK_MENU_SELECIONADO_CHOPEIRAS");
if ($menuselecionado=="consumo") $tpl->block("BLOCK_MENU_SELECIONADO_CONSUMO");
if ($menuselecionado=="cartoes") $tpl->block("BLOCK_MENU_SELECIONADO_CARTOES");
$tpl->show();

?>