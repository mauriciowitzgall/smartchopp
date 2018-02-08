window.onload = function(){
	$(function(){
	$('#capacidade').bind('keypress',mask_litro.litro);
	$('#capacidade').bind('keyup',mask_litro.litro);
	$('#quantidade').bind('keypress',mask_litro.litro);
	$('#quantidade').bind('keyup',mask_litro.litro);	
	});
}