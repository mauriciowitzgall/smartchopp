window.onload = function(){
	$(function(){
	$('#dinheiro').bind('keypress',mask.money);
	$('#dinheiro').bind('keyup',mask.money);
	});
}