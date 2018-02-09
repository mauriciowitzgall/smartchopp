window.onload = function(){
	$(function(){
	$('#novocredito').bind('keypress',mask_money.money);
	$('#novocredito').bind('keyup',mask_money.money);
	});
}