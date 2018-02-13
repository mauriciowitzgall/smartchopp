window.onload = function(){
	$(function(){
	$('#dinheiro').bind('keypress',mask_money.money);
	$('#dinheiro').bind('keyup',mask_money.money);
	});
}