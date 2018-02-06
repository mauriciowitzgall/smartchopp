<?php


$tpl = new Template("menu.html");
if ($menuselecionado=="configuracoes") $tpl->block("BLOCK_MENU_SELECIONADO_CONFIGURACOES");
if ($menuselecionado=="consumidores") $tpl->block("BLOCK_MENU_SELECIONADO_CONSUMIDORES");
if ($menuselecionado=="chopes") $tpl->block("BLOCK_MENU_SELECIONADO_CHOPES");
if ($menuselecionado=="chopeiras") $tpl->block("BLOCK_MENU_SELECIONADO_CHOPEIRAS");
if ($menuselecionado=="atendimentos") $tpl->block("BLOCK_MENU_SELECIONADO_ATENDIMENTOS");
if ($menuselecionado=="cartoes") $tpl->block("BLOCK_MENU_SELECIONADO_CARTOES");
$tpl->show();

?>