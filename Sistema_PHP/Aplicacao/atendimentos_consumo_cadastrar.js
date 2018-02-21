window.onload = function(){
	$(function(){
	$('#qtd').bind('keypress',mask_litro.litro);
	$('#qtd').bind('keyup',mask_litro.litro);	
	});
}

function atualiza_chope(chopeira) {
	//alert(chopeira);
	$.post("ajax_verifica_chope.php", { 
			chopeira: chopeira 
	}, function(valor) {		
		//alert(valor);
		if (valor==0) {
			$("#chopes").val(""); //Selecionar item 'SELECIONE'
			$("#valuni").val("");												
		} else {			
			valor=valor.split("|");
			chope_codigo=valor[0];
			chope_nome=valor[1];
			valuni=valor[2];
			$("#chope").val(chope_nome); //Selecionar item 'SELECIONE'
			$("#chope_codigo").val(chope_codigo); //Selecionar item 'SELECIONE'
			$("#valuni").val(valuni);			
			
		}

	});
}


function atualiza_valtot (qtd) {
	//qtd=$("#qtd").val();
	console.log(qtd);
	qtd=qtd.replace(".","");
	qtd=qtd.replace(",",".");
	valuni=$("#valuni").val();
	valuni=valuni.replace("R$ ","");
	valuni=valuni.replace(".","");
	valuni=valuni.replace(",",".");
	valtot=valuni*qtd;	
	$("#valtot").val("R$ "+valtot.number_format(2,",",""));
	saldo=$("#saldo").val();
	saldo=saldo.replace("R$ ","");
	saldo=saldo.replace(".","");
	saldo=saldo.replace(",",".");	
	if (valtot>saldo) {
		alert("A quantidade digitada gera uma valor total de consumo maior que o saldo disponível");
		$("#qtd").val("");
		$("#qtd").focus();
		$("#valtot").val("R$ 0,00");;	
	}
}

