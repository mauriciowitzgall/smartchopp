window.onload = function(){
    id('telefone').onkeyup = function(){
        mascara( this, mtel );
    }
	$(function(){
		$('#creditoinicial').bind('keypress',mask_money.money);
		$('#creditoinicial').bind('keyup',mask_money.money);
	});

	$("#rfid").focus();
}

function verifica_consumidor (telefone) {
	if ((telefone.length == 15)||(telefone.length == 14)) {
		$.post("ajax_verifica_consumidor.php", { 
			telefone: telefone 
		}, function(valor) {		
			if (valor==0) {
				$("#consumidor_id").val("");
				$("#consumidor").val("");			
				document.forms["form1"].consumidor.disabled = false;
				$("#consumidor").focus();
			} else {			
				valor=valor.split("|");
				codigo=valor[0];
				nome=valor[1];
				$("#consumidor_id").val(codigo);
				$("#consumidor").val(nome);
				document.forms["form1"].consumidor.disabled = true;
				$("#creditoinicial").focus();
				//Verifica qual é o ultimo saldo do consumidor no local, e popula saldo anterior

				$.post("ajax_verifica_saldoanterior.php", { 
					consumidor: codigo 
				}, function(valor) {
					creditoanterior=parseFloat(valor);
					console.log(creditoanterior);
					$("#creditoanterior").val("R$ "+creditoanterior.number_format(2,",",""));
					
				});
			}

		});
	} else if (telefone.length != 0) {
		alert("Telefone Inválido!");
		$("#telefone").focus();
		$("#telefone").val("");		
	} else if (telefone.length==0) {
		$("#consumidor_id").val("");
		$("#consumidor").val("");			
		document.forms["form1"].consumidor.disabled = false;
		$("#consumidor").focus();
	}
}

function valida_cartao (rfid) {
	//06 89 16 9E
	if (rfid!="") {
		$.post("ajax_verifica_cartao.php", { 
			rfid: rfid 
		}, function(valor) {
			//alert(valor);
			valor=valor.split("|");
			consumidor=valor[1];
			permicao=valor[0];
			if (permicao=="permitido") {
				//alert("Liberado");
			} else if (permicao=="duplicado" ){			
				alert("Este cartão já está sendo usado por "+consumidor);
				$("#rfid").val("");
				$("#rfid").focus();
			} else {
				alert("Erro!");
			}
		});
	}
}

function valida_credito_inicial(valor) {
	//console.log(valor);
	creditoinicial=valor.replace("R$ ","");
	creditoinicial=creditoinicial.replace(".","");
	creditoinicial=creditoinicial.replace(",",".");
	//console.log(creditoinicial);

	creditoanterior=$("input[name=creditoanterior]").val();
	creditoanterior=creditoanterior.replace("R$ ","");
	creditoanterior=creditoanterior.replace(".","");
	creditoanterior=creditoanterior.replace(",",".");
	//console.log(creditoanterior);

	totalcreditoinicial=parseFloat(creditoanterior)+parseFloat(creditoinicial);

	$("input[name=totalcreditoinicial]").val("R$ "+totalcreditoinicial.number_format(2,",",""));

}
