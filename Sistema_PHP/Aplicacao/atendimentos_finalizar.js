window.onload = function(){
	$(function(){
	$('#saldodevolvido').bind('keypress',mask_money.money);
	$('#saldodevolvido').bind('keyup',mask_money.money);
	});
}