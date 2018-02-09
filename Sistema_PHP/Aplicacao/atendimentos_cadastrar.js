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
